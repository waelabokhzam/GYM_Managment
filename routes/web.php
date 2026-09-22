<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PlayerController;
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
        'showLogin'
    ])->name('login');


    Route::post('/login', [
        AuthController::class,
        'login'
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

    //  Dashboard

    Route::get('/dashboard', function () {

        return view('dashboard');

    })->name('dashboard');


    Route::post('/logout', [
        AuthController::class,
        'logout'
    ])->name('logout');

    Route::resource('players', PlayerController::class);
});
