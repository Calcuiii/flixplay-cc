<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'film_id',
        'last_watched_at',
        'is_completed', // ✅ TAMBAHKAN
    ];

    protected $casts = [
        'last_watched_at' => 'datetime',
        'is_completed' => 'boolean', // ✅ TAMBAHKAN
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}