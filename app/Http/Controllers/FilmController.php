<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(Request $request): View
    {
        $page = $request->get('page', 1);
        $films = Film::where('status', 'published')
            ->with('genre')
            ->paginate(12);

        return view('films.index', ['films' => $films]);
    }

    public function show(Film $film): View
    {
        $film->load('genre');
        
        $relatedFilms = Film::where('genre_id', $film->genre_id)
            ->where('id', '!=', $film->id)
            ->where('status', 'published')
            ->limit(6)
            ->get();

        return view('films.show', [
            'film' => $film,
            'relatedFilms' => $relatedFilms,
        ]);
    }

    public function search(Request $request): View
    {
        $keyword = $request->get('q', '');
        
        $films = Film::where('status', 'published')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('director', 'like', "%{$keyword}%");
            })
            ->with('genre')
            ->paginate(12);

        return view('films.search', [
            'films' => $films,
            'keyword' => $keyword,
        ]);
    }

    public function byGenre(Genre $genre): View
    {
        $films = $genre->films()
            ->where('status', 'published')
            ->with('genre')
            ->paginate(12);

        return view('films.genre', [
            'films' => $films,
            'genre' => $genre,
        ]);
    }
}
