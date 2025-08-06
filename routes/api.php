<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AirportsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

// 💡 Rate limiter
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {

    // 🔐 AUTH: Login & Registrasi
    Route::prefix('auth')->group(function () {
        Route::post('login', [UserController::class, 'login']);
        Route::post('registrasi', [UserController::class, 'store']);
        Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);
    });

    // 👥 Hanya untuk user yang sudah login
    Route::middleware(['auth:sanctum'])->group(function () {

        // 🛡️ ADMIN: Full access
        Route::middleware('role:Admin')->group(function () {
            Route::get('users/list-data-paginate', [UserController::class, 'listPaginate']);
            Route::apiResource('users', UserController::class);
            Route::post('/users/{id}/restore', [UserController::class, 'restore']);

            // Full akses ke airport
            Route::apiResource('airports', AirportsController::class);
        });

        // 👤 USER: Read-only access (pakai prefix 'public')
        Route::middleware('role:User')->prefix('public')->group(function () {
            Route::get('airports', [AirportsController::class, 'index']);
            Route::get('airports/{airport}', [AirportsController::class, 'show']);
        });
    });

});
