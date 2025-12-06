<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'subscription_status',
        'premium_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'premium_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function isPremium(): bool
    {
        if ($this->subscription_status === 'premium' && $this->premium_expires_at) {
            return $this->premium_expires_at->isFuture();
        }
        return false;
    }

    // Relationship dengan orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relationship dengan ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Relationship dengan reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}

