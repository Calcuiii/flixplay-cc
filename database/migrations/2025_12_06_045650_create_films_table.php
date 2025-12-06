<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('genre_id')->nullable()->constrained('genres')->onDelete('set null');
            $table->integer('duration')->comment('duration in minutes');
            $table->year('release_year');
            $table->string('director')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('video_url')->nullable();
            $table->decimal('rating', 3, 1)->default(0)->comment('average rating');
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};