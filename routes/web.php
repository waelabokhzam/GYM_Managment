<?php

use App\Http\Controllers\Web\AttendanceController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\FeedbackController ;
use App\Http\Controllers\Web\FinancialTransactionController;
use App\Http\Controllers\Web\GameController;
use App\Http\Controllers\Web\InternalRequestController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\PlayerController;
use App\Http\Controllers\Web\ReceiptController;
use App\Http\Controllers\Web\RoleController;
use App\Http\Controllers\Web\SubscriptionController;
use App\Http\Controllers\Web\TimeSlotController;
use App\Http\Controllers\Web\TrainerController;
use App\Http\Controllers\Web\TrainerTimeSlotController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\PlayerGameController;
use App\Http\Controllers\Web\TrainerGameTimeSlotController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {

    // Route::get('/register', [
    //     AuthController::class,
    //     'showRegister'
    // ])->name('register');

    // Route::post('/register', [
    //     AuthController::class,
    //     'register'
    // ])->name('register');

    Route::get('/login', [
        AuthController::class,
        'showLogin',
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->name('login.store');

});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| هذه الصفحات تحتاج إلى تسجيل دخول.
|
*/

Route::middleware('auth')->group(function () {

    Route::post('/notifications/{notification}/open', [
    NotificationController::class,
    'open',
    ])->name('notifications.open');

    Route::post('/notifications/read-all', [
        NotificationController::class,
        'markAllAsRead',
    ])->name('notifications.read-all');
    //  Dashboard

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'permission:reports.view'])
    ->name('dashboard');

    // Games

    Route::resource('games', GameController::class);

    // TimeSlots

    Route::resource('timeslots', TimeSlotController::class);

    Route::resource('players', PlayerController::class);
    Route::resource('trainers', TrainerController::class);
    Route::resource('receipts', ReceiptController::class);
    // Logout

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ])->name('logout');


    Route::resource('subscriptions', SubscriptionController::class);

    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('trainer-time-slots',TrainerTimeSlotController::class);

    Route::resource('player-games',PlayerGameController::class);

    Route::resource('internal-requests',InternalRequestController::class);

    Route::resource('financial-transactions',FinancialTransactionController::class);
    Route::resource('trainer-game-time-slots',TrainerGameTimeSlotController::class);

    Route::prefix('feedback')->name('feedback.')->group(function () {
    // قائمة الملاحظات
    Route::get('/', [FeedbackController::class, 'index'])->name('index');

    // صفحة عرض الملاحظة المفصلة (Show)
    Route::get('/{feedback}', [FeedbackController::class, 'show'])->name('show');

    // تحديث الحالة (PATCH)
    Route::patch('/{feedback}/status', [FeedbackController::class, 'updateStatus'])->name('updateStatus');
    Route::resource('attendances', AttendanceController::class);

    
    });
    Route::post(
        'attendances/{attendance}/checkout',
        [AttendanceController::class, 'checkout']
    )
        ->name('attendances.checkout');

    });
