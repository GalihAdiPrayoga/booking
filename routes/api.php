<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
});

Route::middleware(['enable.cors', 'throttle:api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [UserController::class, 'login']);
        Route::post("registrasi", [UserController::class, 'store']);
        
        Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout']);
        });
    });

    Route::middleware(['auth:sanctum'])->group(function() {
        Route::get('users/list-data-paginate', [UserController::class, 'listPaginate']);
        Route::apiResources(['users' => UserController::class,]);
        Route::post('/users/{id}/restore', [UserController::class, 'restore']);

    });
});
