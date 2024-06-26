<?php

use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::as('auth.')->middleware(ProtectAgainstSpam::class)->group(function () {
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
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forgot-password', 'create')->name('password.forgot');
        Route::post('forgot-password', 'store');
        Route::post('forgot-password-resend', 'resend')->name('password.forgot.resend');
    });
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password/{token}', 'store');
    });
});

Route::as('app.')->prefix('app')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
    });
});
