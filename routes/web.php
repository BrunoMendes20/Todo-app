<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/users', [AuthController::class, 'store'])->name('users.store');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});


Route::middleware('auth')->group(
    function () {
        Route::get('/', [TaskController::class, 'index'])->name('home');
        Route::resource('tasks', TaskController::class)->except('show');

        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    }
);
