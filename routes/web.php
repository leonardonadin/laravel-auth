<?php

use App\Http\Controllers\Site\Auth\LoginController;
use App\Http\Controllers\Site\Auth\RegisterController;
use App\Http\Controllers\Site\Auth\VerifyEmailController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('register', [RegisterController::class, 'register'])->name('site.auth.register');

Route::as('site.')->prefix('site')->group(function () {
    Route::as('auth.')->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('login', 'index')->name('login');
            Route::post('login', 'login');
            Route::post('logout', 'logout')->name('logout');
        });
        Route::controller(RegisterController::class)->group(function () {
            Route::get('register', 'index')->name('register');
            Route::post('register', 'register');
        });
        Route::controller(VerifyEmailController::class)->group(function () {
            Route::get('verify-email', 'create')->name('verify-email');
            Route::post('verify-email', 'store');
            Route::post('verify-email-resend', 'resend')->name('verify-email.resend');
            Route::get('verify-email/{email}/{token}', 'verify')->name('verify-email.verify');
        });
    });

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
    });
});
