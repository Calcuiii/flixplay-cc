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
        'backdrop_url',
        'video_url',
        'rating',
        'is_featured',
        'status',
        'is_trending',  
        'is_popular',  
        'is_hero',   
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'rating' => 'float',
        'is_hero' => 'boolean',
    ];

    // Relationship
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
    public function watchHistory()
    {
        return $this->hasMany(WatchHistory::class);
    }
}
