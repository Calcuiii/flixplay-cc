<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('watch_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('watch_histories', 'is_completed')) {
                $table->boolean('is_completed')->default(false)->after('last_watched_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('watch_histories', function (Blueprint $table) {
            if (Schema::hasColumn('watch_histories', 'is_completed')) {
                $table->dropColumn('is_completed');
            }
        });
    }
};