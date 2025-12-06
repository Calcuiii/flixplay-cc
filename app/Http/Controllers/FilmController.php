<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Models\WatchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $films = Film::where('status', 'published')
            ->with('genre')
            ->paginate(12);

        return view('films.index', ['films' => $films]);
    }

    public function show(Film $film)
    {
        $film->load('genre');
        
        $relatedFilms = Film::where('genre_id', $film->genre_id)
            ->where('id', '!=', $film->id)
            ->where('status', 'published')
            ->limit(6)
            ->get();

        // TAMBAHAN: Check watch history & subscription
        $user = Auth::user();
        $hasWatched = false;
        $isSubscribed = false;
        $canWatch = true; // By default user bisa nonton (belum pernah nonton)
        $watchMessage = '';

        if ($user) {
            // Cek apakah user sudah nonton film ini
            $hasWatched = $user->hasWatched($film->id);
            
            // Cek apakah user subscribe
            $isSubscribed = $user->isSubscribed();

            // Logic:
            // - Jika sudah nonton & tidak subscribe → tidak bisa nonton lagi
            // - Jika sudah nonton & subscribe → bisa nonton (unlimited)
            // - Jika belum nonton → bisa nonton (1x gratis)
            
            if ($hasWatched && !$isSubscribed) {
                $canWatch = false;
                $watchMessage = 'Anda sudah menonton film ini. Upgrade ke premium untuk menonton kembali.';
            } elseif ($hasWatched && $isSubscribed) {
                $canWatch = true;
                $watchMessage = 'Anda berlangganan, nikmati unlimited watch!';
            } else {
                $canWatch = true;
                $watchMessage = 'Anda bisa menonton film ini 1x gratis.';
            }
        }

        return view('films.show', [
            'film' => $film,
            'relatedFilms' => $relatedFilms,
            'hasWatched' => $hasWatched,
            'isSubscribed' => $isSubscribed,
            'canWatch' => $canWatch,
            'watchMessage' => $watchMessage,
        ]);
    }

    // NEW METHOD: Record watch history
    public function watch(Film $film)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Cek apakah user sudah nonton
        if ($user->hasWatched($film->id)) {
            // Jika sudah nonton & tidak subscribe → redirect ke subscription
            if (!$user->isSubscribed()) {
                return redirect()->route('films.show', $film)->with('error', 'Anda sudah menonton film ini. Upgrade untuk menonton kembali.');
            }
        }

        // Record watch history (jika belum ada)
        WatchHistory::firstOrCreate([
            'user_id' => $user->id,
            'film_id' => $film->id,
        ]);

        // Redirect ke video player atau page view
        return redirect()->route('films.show', $film)->with('success', 'Selamat menonton!');
    }

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
        
        return view('films.search', [
            'films' => $films,
            'keyword' => $keyword,
        ]);
    }

    public function byGenre(Request $request, $genreId)
    {
        $films = Film::with('genre')
            ->where('status', 'published')
            ->where('genre_id', $genreId)
            ->paginate(12);
        
        return view('films.genre', [
            'films' => $films,
            'genre' => Genre::find($genreId),
        ]);
    }
}