<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WatchHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get watch history dengan film details, pagination
        $watchHistory = $user->watchHistories()
            ->with('film.genre')
            ->latest('last_watched_at') 
            ->paginate(12);
        
        return view('watch-history.index', compact('watchHistory'));
    }
    
    public function clear()
    {
        $user = Auth::user();
        $user->watchHistories()->delete();
        
        return redirect()->route('watch-history.index')
            ->with('success', 'Riwayat ditonton telah dihapus');
    }
}