<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredFilms = Film::where('is_featured', true)
            ->where('status', 'published')
            ->with('genre')
            ->limit(3)
            ->get();

        $trendingFilms = Film::where('status', 'published')
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $popularFilms = Film::where('status', 'published')
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();

        $genres = Genre::all();

        return view('home', [
            'featuredFilms' => $featuredFilms,
            'trendingFilms' => $trendingFilms,
            'popularFilms' => $popularFilms,
            'genres' => $genres,
        ]);
    }
}