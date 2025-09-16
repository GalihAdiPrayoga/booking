<?php

use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AirportsController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\FlightsClassesController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {
    Route::prefix('public')->group(function () {
        Route::get('airports', [AirportsController::class, 'index']);
        Route::get('airports/{airport}', [AirportsController::class, 'show']);
        Route::get('flights', [FlightController::class, 'index']);
        Route::get('flights/{flight}', [FlightController::class, 'show']);
        Route::get('flightclasses', [FlightsClassesController::class, 'index']);
        Route::get('flightclasses/{flightclass}', [FlightsClassesController::class, 'show']);
    });
    Route::prefix('auth')->group(function () {
        Route::post('login', [UserController::class, 'login']);
        Route::post('registrasi', [UserController::class, 'store']);
        Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::middleware('role:Admin')->group(function () {
            Route::get('users/list-data-paginate', [UserController::class, 'listPaginate']);
            Route::apiResource('users', UserController::class);
            Route::post('/users/{id}/restore', [UserController::class, 'restore']);

            Route::apiResource('airports', AirportsController::class);
            Route::apiResource('flights', FlightController::class);
            Route::apiResource('flightclasses', FlightsClassesController::class);
            Route::apiResource('tickets', TicketsController::class);
        });
        Route::middleware('role:User')->group(function () {
            Route::apiResource('bookings', BookingsController::class);
            Route::apiResource('users', UserController::class);
            Route::put('/profile', [UserController::class, 'updateProfile']);
            Route::post('payments', [PaymentsController::class, 'store']);
            Route::get('payments/{id}', [PaymentsController::class, 'show']);
        });
    });
});
