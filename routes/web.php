<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WatchHistoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFilmController;
use App\Http\Controllers\Admin\AdminGenreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WatchlistController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('/search', [FilmController::class, 'search'])->name('films.search');
Route::get('/genre/{genre}', [FilmController::class, 'byGenre'])->name('films.genre');

// Auth Routes - TIDAK PERLU LOGIN
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Protected Routes - PERLU LOGIN
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
});
// Protected Routes - PERLU LOGIN
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Watch film
    Route::post('/films/{film}/watch', [FilmController::class, 'watch'])->name('films.watch');
    
    // Subscription routes
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::get('/subscription/{plan}/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/{plan}/process', [PaymentController::class, 'process'])->name('payment.process');

    Route::get('/watch-history', [WatchHistoryController::class, 'index'])->name('watch-history.index');
    Route::post('/watch-history/clear', [WatchHistoryController::class, 'clear'])->name('watch-history.clear');
});

// Payment callback
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/subscription/success', [PaymentController::class, 'success'])->name('subscription.success');
Route::get('/subscription/failed', [PaymentController::class, 'failed'])->name('subscription.failed');
Route::get('/subscription/pending', [PaymentController::class, 'pending'])->name('subscription.pending');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/films', AdminFilmController::class);
    Route::resource('/genres', AdminGenreController::class);
});
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Protected Routes - PERLU LOGIN
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Watch film
    Route::post('/films/{film}/watch', [FilmController::class, 'watch'])->name('films.watch');
    
    // ✅ WATCHLIST ROUTES
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/clear', [WatchlistController::class, 'clear'])->name('watchlist.clear'); 
    Route::post('/watchlist/{film}', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/watchlist/{film}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');
    
    // Subscription routes
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');

    Route::middleware('auth')->group(function () {
    
    // Watch film routes
    Route::post('/films/{film}/watch', [FilmController::class, 'watch'])->name('films.watch');
});
});