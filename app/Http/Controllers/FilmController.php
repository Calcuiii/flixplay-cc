<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FilmController extends Controller
{

    public function index()
    {
        $films = Film::with('genre')
            ->latest()
            ->paginate(12);
        
        return view('films.index', compact('films'));
    }

    public function show(Film $film)
    {
        $film->load('genre');
        
        // Cek apakah user sudah login
        $canWatch = false;
        $watchMessage = null;
        
        if (Auth::check()) {
            $canWatch = auth()->user()->canWatchFilm($film->id);
        }
        
        return view('films.show', compact('film', 'canWatch', 'watchMessage'));
    }

    public function watch(Request $request, Film $film)
    {
    // Cek apakah user bisa menonton
    if (!auth()->user()->canWatchFilm($film->id)) {
        return redirect()->route('films.show', $film)
            ->with('error', 'Anda sudah menonton film ini. Berlangganan untuk menonton ulang.');
    }
    
    // ✅ LANGSUNG TANDAI SEBAGAI COMPLETED (UBAH is_completed jadi true)
    WatchHistory::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'film_id' => $film->id,
        ],
        [
            'last_watched_at' => now(),
            'is_completed' => true, // ✅ UBAH INI dari false ke true
        ]
    );
    
    // Redirect ke Google Drive
    return redirect()->away($film->video_url);
    }
}