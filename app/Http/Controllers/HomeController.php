<?php
namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Film Featured
        $featuredFilms = Film::where('is_featured', true)
            ->where('status', 'published')
            ->with('genre')
            ->limit(3)
            ->get();
        
        // ✅ Film Trending - yang dipilih saja
        $trendingFilms = Film::where('is_trending', true)
            ->where('status', 'published')
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();
        
        // ✅ Film Popular - yang dipilih saja
        $popularFilms = Film::where('is_popular', true)
            ->where('status', 'published')
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