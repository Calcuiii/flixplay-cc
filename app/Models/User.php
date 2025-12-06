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

    public function watchHistory()
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

    public function hasWatched($filmId)
    {
        return $this->watchHistory()->where('film_id', $filmId)->exists();
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
}