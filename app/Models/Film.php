<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Film extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'genre_id',
        'duration',
        'release_year',
        'director',
        'poster_url',
        'video_url',
        'rating',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'release_year' => 'integer',
        'duration' => 'integer',
        'rating' => 'float',
        'is_featured' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // Relationship dengan Genre
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Relationship dengan Ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Relationship dengan Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relationship dengan OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get average rating
    public function getAverageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
}