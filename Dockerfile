# FROM php:8.3-cli

# WORKDIR /var/www/html

# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     zip \
#     unzip \
#     libonig-dev \
#     libxml2-dev \
#     libzip-dev \
#     && docker-php-ext-install pdo pdo_mysql zip mbstring \
#     && apt-get clean \
#     && rm -rf /var/lib/apt/lists/*

# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Copy composer files first
# COPY composer.json composer.lock ./

# # IMPORTANT: disable artisan scripts during build
# RUN composer install \
#     --no-interaction \
#     --prefer-dist \
#     --optimize-autoloader \
#     --no-scripts

# # Copy application source
# COPY . .

# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 775 storage bootstrap/cache

# EXPOSE 8000

# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]


# # 1. Gunakan Apache karena sudah sepaket dan stabil untuk Laravel
# FROM php:8.3-apache

# # 2. Install dependencies yang dibutuhkan Laravel
# RUN apt-get update && apt-get install -y \
#     git curl zip unzip libonig-dev libxml2-dev libzip-dev \
#     && docker-php-ext-install pdo pdo_mysql zip mbstring \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

# # 3. Aktifkan modul rewrite Apache (WAJIB untuk Laravel agar Route jalan)
# RUN a2enmod rewrite

# # 4. Ubah DocumentRoot Apache ke folder 'public' Laravel
# # Secara default Apache melihat ke /var/www/html, kita arahkan ke /var/www/html/public
# RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# # 5. Set working directory
# WORKDIR /var/www/html

# # 6. Install Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # 7. Copy seluruh file proyek
# COPY . .

# # 8. Jalankan composer install
# RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# # 9. Atur Permission folder agar Apache bisa menulis file (Sangat Penting!)
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# # 10. Port standar web
# EXPOSE 80 2222

# # Apache sudah otomatis jalan di image ini, tidak perlu CMD aneh-aneh lagi

FROM php:8.3-apache

# 1. Install dependencies & OpenSSH Server (Wajib untuk Azure SSH)
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    openssh-server \
    && docker-php-ext-install pdo pdo_mysql zip mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ### TAMBAHAN BARU 1: Install Composer ###
# Mengambil program Composer dari image resminya
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 2. Konfigurasi SSH (Password harus 'Docker!' agar dikenali Azure)
RUN echo "root:Docker!" | chpasswd
COPY sshd_config /etc/ssh/sshd_config
RUN mkdir -p /var/run/sshd

# 3. Konfigurasi Apache & Laravel
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . .

# ### TAMBAHAN BARU 2: Jalankan Composer Install ###
# Ini akan mendownload folder 'vendor' yang hilang
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 4. Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# COPY startup script dan beri izin eksekusi
COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh

# 5. Expose Port 80 (Web) dan 2222 (SSH Azure)
EXPOSE 80 2222

# Gunakan script ini sebagai perintah utama
ENTRYPOINT ["/usr/local/bin/startup.sh"]

# 6. Jalankan SSH service dan Apache secara bersamaan
CMD service ssh start && apache2-foreground
