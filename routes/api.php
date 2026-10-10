<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\NutritionProgramController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerActivityController;
use App\Http\Controllers\Api\PrivatePlayersController;
use App\Http\Controllers\Api\TrainingProgramController;

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

       // اللاعبين الخاصين بالمدرب
    Route::get('/trainer/private-players', [PrivatePlayersController::class, 'index']);

    // البرنامج التدريبي
    Route::get('/players/{playerId}/training-program', [TrainingProgramController::class, 'show']);
    Route::put('/players/{playerId}/training-program', [TrainingProgramController::class, 'save']);

    // البرنامج التغذوي
    Route::get('/players/{playerId}/nutrition-program', [NutritionProgramController::class, 'show']);
    Route::put('/players/{playerId}/nutrition-program', [NutritionProgramController::class, 'save']);

    Route::post('/feedbacks', [FeedbackController::class, 'store']);

    Route::get('/games', [GameController::class, 'index']);
    });

