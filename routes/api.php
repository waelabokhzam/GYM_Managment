<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerActivityController;


// مسار تسجيل الدخول (مفتوح)
Route::post('/auth/login', [AuthController::class, 'login']);

// مسارات محمية بـ JWT
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    Route::get('/auth/player',[PlayerController::class, 'me']);

    Route::get('/player/subscriptions', [SubscriptionController::class, 'getPlayerSubscriptions']);

    Route::get('/auth/schedule/{day}',[ScheduleController::class, 'day']);

    Route::get('/auth/player/games',[PlayerActivityController::class, 'index']);
    });

