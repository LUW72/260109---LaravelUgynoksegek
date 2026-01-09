<?php

use App\Http\Controllers\AgencyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipateController;
use App\Http\Controllers\UserController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('agency')->group(function () {
        Route::apiResource('agencies', AgencyController::class);
        Route::apiResource('events', EventController::class);

        // 02 - Mondd le a mai napra tervezett eseményeken való részvételedet! (present : = False)
        Route::post('/participates/cancel-today', [ParticipateController::class, 'cancelToday']);        
        // 03 - Állítsd lejárt-ra a legalább 3 hete szervezett események rekordjait (status = 2)!
        Route::post('/events/expire-old-events', [EventController::class, 'expireOldEvents']);
    });

    Route::prefix('admin')->group(function () {
        Route::apiResource('users', UserController::class);

        // 01 - VIP felhasználók neveit és e-mail címeit jelenítsd meg!
        Route::get('/users/vips', [UserController::class, 'vips']);
    });


    
});

