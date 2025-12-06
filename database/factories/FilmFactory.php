<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class FilmFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(3),
            'genre_id' => Genre::inRandomOrder()->first()?->id ?? Genre::factory(),
            'duration' => $this->faker->numberBetween(90, 180),
            'release_year' => $this->faker->year(),
            'director' => $this->faker->name(),
            'poster_url' => 'https://via.placeholder.com/300x450?text=' . urlencode($this->faker->sentence(2)),
            'video_url' => 'https://example.com/videos/' . $this->faker->slug() . '.mp4',
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'is_featured' => $this->faker->boolean(20),
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
        ];
    }
}