<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BusController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TripStationController;

Route::get('/', function () {
    return view('welcome');
});

// User dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/bookings/create', [BookingController::class, 'create'])->name('user.bookings.create');
    Route::post('/bookings/search', [BookingController::class, 'search'])->name('user.bookings.search');
    Route::get('/bookings/seats', [BookingController::class, 'seats'])->name('user.bookings.seats');
    Route::post('/bookings/store', [BookingController::class, 'store'])->name('user.bookings.store');
    Route::get('/bookings', [BookingController::class, 'userIndex'])->name('user.bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'userShow'])->name('user.bookings.show');
});

// Admin dashboard and CRUD
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('cities', CityController::class);
    Route::resource('trips', TripController::class);
    Route::resource('buses', BusController::class);
    Route::resource('bookings', BookingController::class);

    // Add nested routes for trip stations
    Route::prefix('trips/{trip}/stations')->name('trip_stations.')->group(function () {
        Route::get('/', [TripStationController::class, 'index'])->name('index');
        Route::get('/create', [TripStationController::class, 'create'])->name('create');
        Route::post('/', [TripStationController::class, 'store'])->name('store');
        Route::get('/{tripStation}/edit', [TripStationController::class, 'edit'])->name('edit');
        Route::put('/{tripStation}', [TripStationController::class, 'update'])->name('update');
        Route::delete('/{tripStation}', [TripStationController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__ . '/auth.php';
