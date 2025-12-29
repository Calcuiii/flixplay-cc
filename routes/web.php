<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    FilmController,
    DashboardController,
    SubscriptionController,
    PaymentController,
    WatchHistoryController,
    WatchlistController,
    ContactController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController
};
use App\Http\Controllers\Admin\{
    AdminDashboardController,
    AdminFilmController,
    AdminGenreController
};

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('/search', [FilmController::class, 'search'])->name('films.search');
Route::get('/genre/{genre}', [FilmController::class, 'byGenre'])->name('films.genre');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS
|--------------------------------------------------------------------------
*/
Route::post('/films/{film}/watch', [FilmController::class, 'watch'])
        ->name('films.watch');

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');

    // Subscription
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::get('/subscription/{plan}/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/{plan}/process', [PaymentController::class, 'process'])->name('payment.process');

    // Watchlist
    Route::get('/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::post('/watchlist/{film}', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/watchlist/{film}', [WatchlistController::class, 'destroy'])
    ->name('watchlist.destroy');
    Route::post('/watchlist/clear', [WatchlistController::class, 'clear'])
    ->name('watchlist.clear');

    // Watch history
    Route::get('/watch-history', [WatchHistoryController::class, 'index'])->name('watch-history.index');
    Route::post('/watch-history/clear', [WatchHistoryController::class, 'clear'])->name('watch-history.clear');
});

/*
|--------------------------------------------------------------------------
| PAYMENT CALLBACK
|--------------------------------------------------------------------------
*/
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
Route::get('/payment/error', [PaymentController::class, 'error'])->name('payment.error');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/subscription/success', [PaymentController::class, 'success'])->name('subscription.success');
Route::get('/subscription/failed', [PaymentController::class, 'failed'])->name('subscription.failed');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/films', AdminFilmController::class);
    Route::resource('/genres', AdminGenreController::class);
});
