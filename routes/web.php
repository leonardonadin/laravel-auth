<?php

use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('site.home');

Route::namespace('Site')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('login', 'index')->name('site.login');
        Route::post('login', 'login');
    });
    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'index')->name('site.register');
        Route::post('register', 'register');
        Route::get('verify-email', 'verifyEmail')->name('site.verify-email');
    });
});
