<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Action', 'description' => 'Film penuh aksi dan petualangan'],
            ['name' => 'Drama', 'description' => 'Film drama yang menyentuh hati'],
            ['name' => 'Comedy', 'description' => 'Film komedi yang menghibur'],
            ['name' => 'Horror', 'description' => 'Film horor yang mendebarkan'],
            ['name' => 'Romance', 'description' => 'Film percintaan yang romantis'],
            ['name' => 'Sci-Fi', 'description' => 'Film futuristik dan fiksi ilmiah'],
            ['name' => 'Thriller', 'description' => 'Film thriller yang mencekam'],
            ['name' => 'Animation', 'description' => 'Film animasi untuk segala usia'],
        ];

        foreach ($genres as $genre) {
            Genre::create($genre);
        }
    }
}