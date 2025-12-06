<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GenreResource;
use App\Models\Genre;

class GenreController extends Controller
{
    // GET /api/genres - List semua genre
    public function index()
    {
        $genres = Genre::all();
        return GenreResource::collection($genres);
    }

    // GET /api/genres/{id} - Detail genre
    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }
}