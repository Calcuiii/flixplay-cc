<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watch_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade');
            $table->timestamp('watched_at')->useCurrent();
            $table->timestamps();
            $table->timestamp('last_watched_at')->nullable();
            
            // User hanya bisa punya 1 watch record per film
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watch_histories');
    }
};