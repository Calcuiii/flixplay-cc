<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get watch history dengan film details, pagination
        $watchHistory = $user->watchHistory()
            ->with('film.genre')
            ->latest('watched_at')
            ->paginate(12);

        return view('watch-history.index', compact('watchHistory'));
    }

    public function clear()
    {
        $user = Auth::user();
        $user->watchHistory()->delete();

        return redirect()->route('watch-history.index')->with('success', 'Riwayat ditonton telah dihapus');
    }
}
