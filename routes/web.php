<?php

use App\Http\Controllers\Admin\FilmController as AdminFilmController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\SalleController as AdminSalleController;
use App\Http\Controllers\Admin\SeanceController as AdminSeanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SeanceController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

// Public Film and Session routes
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('/seances/{seance}', [SeanceController::class, 'show'])->name('seances.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');

    // Payment routes
    Route::get('/paiements/create/{reservation}', [PaiementController::class, 'create'])->name('paiements.create');
    Route::post('/paiements', [PaiementController::class, 'store'])->name('paiements.store');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('films', AdminFilmController::class);
        Route::resource('seances', AdminSeanceController::class);
        Route::resource('salles', AdminSalleController::class);
        Route::resource('reservations', AdminReservationController::class)->only(['index', 'update', 'destroy']);
    });
});

require __DIR__.'/settings.php';
