<?php
namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Film Featured - kalau kosong, ambil 3 film terbaru
        $featuredFilms = Film::where('is_featured', true)
            ->where('status', 'published')
            ->with('genre')
            ->limit(3)
            ->get();
        
        if ($featuredFilms->isEmpty()) {
            $featuredFilms = Film::where('status', 'published')
                ->with('genre')
                ->latest()
                ->limit(3)
                ->get();
        }
        
        // Film Trending - kalau kosong, ambil berdasarkan rating tertinggi
        $trendingFilms = Film::where('is_trending', true)
            ->where('status', 'published')
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();
        
        if ($trendingFilms->isEmpty()) {
            $trendingFilms = Film::where('status', 'published')
                ->with('genre')
                ->orderByDesc('rating')
                ->limit(6)
                ->get();
        }
        
        // Film Popular - kalau kosong, ambil berdasarkan rating
        $popularFilms = Film::where('is_popular', true)
            ->where('status', 'published')
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(6)
            ->get();
        
        if ($popularFilms->isEmpty()) {
            $popularFilms = Film::where('status', 'published')
                ->with('genre')
                ->orderByDesc('rating')
                ->limit(6)
                ->get();
        }
        
        $genres = Genre::all();
        
        return view('home', [
            'featuredFilms' => $featuredFilms,
            'trendingFilms' => $trendingFilms,
            'popularFilms' => $popularFilms,
            'genres' => $genres,
        ]);
    }
}