<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'film_id',
        'title',
        'content',
        'is_helpful',
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan Film
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}