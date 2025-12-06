<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FilmResource;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    // GET /api/films - List semua film dengan pagination
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 12);
        
        $films = Film::with('genre')
            ->where('status', 'published')
            ->paginate($per_page);
        
        return FilmResource::collection($films);
    }

    // GET /api/films/{id} - Detail film
    public function show(Film $film)
    {
        $film->load('genre');
        return new FilmResource($film);
    }

    // GET /api/films/trending - Film trending
    public function trending(Request $request)
    {
        $limit = $request->get('limit', 6);
        
        $films = Film::with('genre')
            ->where('status', 'published')
            ->orderByDesc('rating')
            ->limit($limit)
            ->get();
        
        return FilmResource::collection($films);
    }

    // GET /api/films/featured - Film featured
    public function featured(Request $request)
    {
        $limit = $request->get('limit', 3);
        
        $films = Film::with('genre')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->limit($limit)
            ->get();
        
        return FilmResource::collection($films);
    }

    // GET /api/films/search?q=keyword - Search film
    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        
        if (!$keyword) {
            return response()->json(['error' => 'Query parameter "q" is required'], 400);
        }
        
        $films = Film::with('genre')
            ->where('status', 'published')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('director', 'like', "%{$keyword}%");
            })
            ->paginate(12);
        
        return FilmResource::collection($films);
    }

    // GET /api/films/genre/{genre_id} - Film by genre
    public function byGenre(Request $request, $genreId)
    {
        $films = Film::with('genre')
            ->where('status', 'published')
            ->where('genre_id', $genreId)
            ->paginate(12);
        
        return FilmResource::collection($films);
    }
}