<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Watchlist;
use App\Models\User;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        
        $watchlistFilms = $user->watchlistFilms()
            ->with('genre')
            ->latest('watchlists.created_at')
            ->get();

        return view('watchlist.index', compact('watchlistFilms'));
    }

    public function store(Request $request, Film $film)
    {
        /** @var User $user */
        $user = auth()->user();
        
        $exists = Watchlist::where('user_id', $user->id)
            ->where('film_id', $film->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Film sudah ada di watchlist Anda');
        }

        Watchlist::create([
            'user_id' => $user->id,
            'film_id' => $film->id,
        ]);

        return back()->with('success', 'Film berhasil ditambahkan ke watchlist');
    }

    public function destroy(Film $film)
    {
        /** @var User $user */
        $user = auth()->user();
        
        Watchlist::where('user_id', $user->id)
            ->where('film_id', $film->id)
            ->delete();

        return back()->with('success', 'Film berhasil dihapus dari watchlist');
    }

    public function clear()
    {
        /** @var User $user */
        $user = auth()->user();
        
        Watchlist::where('user_id', $user->id)->delete();

        return redirect()->route('watchlist.index')
            ->with('success', 'Watchlist berhasil dikosongkan');
    }
}