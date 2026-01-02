#!/bin/bash

# --- BAGIAN 1: PERSIAPAN FOLDER (Punya Anda + Tambahan Log & Bootstrap) ---
# # 1. Pastikan folder storage ada (Solusi Gambar Hilang)
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views

# # ### TAMBAHAN BARU: Buat folder logs dan bootstrap cache agar tidak error permission ###
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache


# --- BAGIAN 2: PERMISSION (Punya Anda + Tambahan Bootstrap) ---
# 2. Atur izin (Permissions)
# Saya tambahkan 'bootstrap/cache' agar Laravel bisa menyimpan cache config
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# --- BAGIAN 3: PEMBERSIHAN CACHE (TAMBAHAN PENTING) ---
# ### TAMBAHAN BARU: Wajib dijalankan setelah edit Middleware/Controller agar tidak Error 500 ###
# cd /var/www/html
# php artisan optimize:clear
# php artisan view:clear
# php artisan config:clear


# --- BAGIAN 4: SETUP APLIKASI (Punya Anda) ---
# 3. Buat Symlink Storage
php artisan storage:link

# 4. Jalankan Migrasi Database (AMAN)
# --force diperlukan karena kita di environment 'production'
# php artisan migrate --force

# CATATAN: db:seed TIDAK dimasukkan di sini agar data tidak ganda.
# php artisan db:seed --class=GenreSeeder --force
# php artisan db:seed --class=FilmSeeder
# php artisan db:seed --class=UserSeeder --force
# php artisan db:seed --class=SubscriptionPlanSeeder --force


# --- BAGIAN 5: START SERVER (Punya Anda) ---
# 5. Jalankan SSH (Agar tidak Conn Close)
service ssh start

# 6. Jalankan Apache (Server Website)
apache2-foreground
