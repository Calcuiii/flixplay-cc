<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting! Genre harus dibuat duluan karena Film mereferensikan Genre
        $this->call([
            GenreSeeder::class,
            UserSeeder::class,
            FilmSeeder::class,
        ]);
    }
}