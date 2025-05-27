<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    // Return available seats
    Route::get('/seats/available', [BookingApiController::class, 'availableSeats']);

    // Create a new booking
    Route::post('/bookings', [BookingApiController::class, 'store']);
});

