<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'subscription_status',    
    'premium_expires_at',     
    'phone',
    'is_admin',
];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'premium_expires_at' => 'datetime',
    ];

    public function watchHistories()
    {
        return $this->hasMany(WatchHistory::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'completed')
            ->where('expires_at', '>', now())
            ->first();
    }

    // ✅ UPDATE METHOD INI (gunakan watchHistories)
    public function hasWatched($filmId)
    {
        return $this->watchHistories()->where('film_id', $filmId)->exists();
    }

    public function isSubscribed()
    {
        // Check dari tabel subscriptions
        $active = $this->activeSubscription();
        if ($active) {
            return true;
        }
        
        // ✅ Fallback ke premium_expires_at
        if (!$this->premium_expires_at) {
            return false;
        }
        
        return $this->premium_expires_at->isFuture();
    }

    public function getSubscriptionStatusAttribute()
    {
        if ($this->isSubscribed()) {
            return 'active';
        }
        return 'expired';
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function watchlistFilms()
    {
        return $this->belongsToMany(Film::class, 'watchlists');
    }

    // Helper method untuk cek film ada di watchlist
    public function hasInWatchlist($filmId)
    {
        return $this->watchlists()->where('film_id', $filmId)->exists();
    }

    public function canWatchFilm(int $filmId): bool
    {
        // Premium selalu boleh
        if ($this->hasActiveSubscription()) {
            return true;
        }

        // Free: boleh jika BELUM pernah klik film ini
        return !$this->watchHistories()
            ->where('film_id', $filmId)
            ->exists();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('status', 'completed')
            ->where('expires_at', '>', now())
            ->exists();
    }
}