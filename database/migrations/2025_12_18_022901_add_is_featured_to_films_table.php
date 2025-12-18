<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('films', function (Blueprint $table) {
            // Cek apakah kolom sudah ada
            if (!Schema::hasColumn('films', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            if (Schema::hasColumn('films', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
        });
    }
};