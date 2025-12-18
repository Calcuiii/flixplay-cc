<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        // Optional: Create specific featured films
        Film::factory(3)->create(['is_featured' => true]);
    }
}
