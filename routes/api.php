<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Support\Facades\Route;

// مسار تسجيل الدخول (مفتوح)
Route::post('/auth/login', [AuthController::class, 'login']);

// مسارات محمية بـ JWT
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    Route::get('/auth/player',[PlayerController::class, 'me']);
    
});
