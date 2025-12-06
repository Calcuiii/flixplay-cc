<?php

use App\Http\Controllers\Api\FilmController;
use App\Http\Controllers\Api\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Protected routes (memerlukan authentication)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes - FILMS
Route::get('/films', [FilmController::class, 'index']);
Route::get('/films/trending', [FilmController::class, 'trending']);
Route::get('/films/featured', [FilmController::class, 'featured']);
Route::get('/films/search', [FilmController::class, 'search']);
Route::get('/films/genre/{genre_id}', [FilmController::class, 'byGenre']);
Route::get('/films/{film}', [FilmController::class, 'show']);

// Public API Routes - GENRES
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);