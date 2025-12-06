<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom untuk subscription
            $table->enum('subscription_status', ['free', 'premium'])->default('free')->after('email');
            $table->timestamp('premium_expires_at')->nullable()->after('subscription_status');
            $table->string('phone')->nullable()->after('premium_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['subscription_status', 'premium_expires_at', 'phone']);
        });
    }
};