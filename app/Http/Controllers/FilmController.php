<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\WatchHistory;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with('genre')->latest()->paginate(12);
        return view('films.index', compact('films'));
    }

   public function show(Film $film)
    {
        $canWatch = false;

        if (Auth::check()) {
            $canWatch = auth()->user()->canWatchFilm($film->id);
        }

        return view('films.show', compact('film', 'canWatch'));
    }


    public function watch(Film $film)
    {
        $user = auth()->user();

        // 🔐 PREMIUM → selalu boleh
        if ($user->hasActiveSubscription()) {

            WatchHistory::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'film_id' => $film->id,
                ],
                [
                    'last_watched_at' => now(),
                    'is_completed' => true,
                ]
            );

            return redirect()->away($film->video_url);
        }

        // 🎁 FREE USER — cek apakah SUDAH PERNAH KLIK
        $alreadyWatched = WatchHistory::where('user_id', $user->id)
            ->where('film_id', $film->id)
            ->exists();

        if ($alreadyWatched) {
            return redirect()->route('subscription.plans')
                ->with('error', 'Kesempatan menonton gratis untuk film ini sudah digunakan.');
        }

        // 🔒 LANGSUNG KUNCI SAAT KLIK
        WatchHistory::create([
            'user_id' => $user->id,
            'film_id' => $film->id,
            'last_watched_at' => now(),
            'is_completed' => true, // langsung true
        ]);

        return redirect()->away($film->video_url);
    }
}
