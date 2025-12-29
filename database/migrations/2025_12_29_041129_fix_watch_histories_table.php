<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('watch_histories', function (Blueprint $table) {
            // ✅ Hapus kolom watched_at yang duplikat
            if (Schema::hasColumn('watch_histories', 'watched_at')) {
                $table->dropColumn('watched_at');
            }
            
            // ✅ Tambah kolom is_completed kalau belum ada
            if (!Schema::hasColumn('watch_histories', 'is_completed')) {
                $table->boolean('is_completed')->default(true)->after('last_watched_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('watch_histories', function (Blueprint $table) {
            $table->timestamp('watched_at')->nullable();
            $table->dropColumn('is_completed');
        });
    }
};