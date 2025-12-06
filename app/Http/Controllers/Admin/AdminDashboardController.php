<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Film;
use App\Models\Subscription;
use App\Models\WatchHistory;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalFilms = Film::count();
        $activeSubscriptions = Subscription::where('status', 'completed')
            ->where('expires_at', '>', now())
            ->count();
        $totalWatches = WatchHistory::count();

        $recentSubscriptions = Subscription::with('user', 'plan')
            ->where('status', 'completed')
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalFilms',
            'activeSubscriptions',
            'totalWatches',
            'recentSubscriptions'
        ));
    }
}