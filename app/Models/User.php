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
        'subscription_type',
        'subscription_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_expires_at' => 'datetime',
    ];

    // ✅ UBAH DARI watchHistory() ke watchHistories() (PLURAL)
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
        // Check dari tabel subscriptions (lebih akurat)
        $active = $this->activeSubscription();
        if ($active) {
            return true;
        }
        // Fallback ke subscription_expires_at
        if (!$this->subscription_expires_at) {
            return false;
        }
        return $this->subscription_expires_at->isFuture();
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

    /**
     * Cek apakah user sudah pernah menonton film sampai selesai
     */
    public function hasWatchedComplete($filmId)
    {
        return $this->watchHistories()
            ->where('film_id', $filmId)
            ->where('is_completed', true)
            ->exists();
    }

    /**
     * Cek apakah user bisa menonton film
     * (belum pernah nonton atau masih ada subscription aktif)
     */
    public function canWatchFilm($filmId)
    {
        // Jika belum pernah nonton sama sekali, boleh
        $hasWatched = $this->hasWatchedComplete($filmId);
        
        if (!$hasWatched) {
            return true;
        }
        
        // Jika sudah pernah nonton, cek subscription
        // Hanya user dengan subscription aktif yang bisa nonton ulang
        return $this->hasActiveSubscription();
    }

    /**
     * Cek apakah user punya subscription aktif
     */
    public function hasActiveSubscription()
    {
        if (!$this->subscription) {
            return false;
        }
        
        return $this->subscription->status === 'active' 
            && $this->subscription->ends_at > now();
    }
}