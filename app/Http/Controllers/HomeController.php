<?php
namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // ✅ Hero Films - untuk slider utama (pakai backdrop)
        $heroFilms = Film::where('is_hero', true)
            ->where('status', 'published')
            ->whereNotNull('backdrop_url')  // Harus ada backdrop
            ->with('genre')
            ->orderByDesc('rating')
            ->limit(5)
            ->get();
        
        // Featured Films
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
        
        // Trending Films
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
        
        // Popular Films
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
            'heroFilms' => $heroFilms,  // ✅ Tambahkan
            'featuredFilms' => $featuredFilms,
            'trendingFilms' => $trendingFilms,
            'popularFilms' => $popularFilms,
            'genres' => $genres,
        ]);
    }
}