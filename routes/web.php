<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

Route::get("/", [FrontendController::class, "index"]);

Route::middleware(['guest.user'])
        ->controller(AuthController::class)
        ->group(function () {
    
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');

    Route::get('/register','showRegisterForm')->name('register');
    Route::post('/register',  'register');

    Route::get('/forgot-password', 'showForgotPasswordForm')->name('password.request');
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');

    Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});