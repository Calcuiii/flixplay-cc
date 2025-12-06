<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilmController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('/search', [FilmController::class, 'search'])->name('films.search');
Route::get('/genre/{genre}', [FilmController::class, 'byGenre'])->name('films.genre');
