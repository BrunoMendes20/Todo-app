<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes accessible only to guests (unauthenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Registration routes
    Route::get('/register', [AuthController::class, 'create'])
        ->name('register');

    Route::post('/users', [AuthController::class, 'store'])
        ->name('users.store');

    // Login routes
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'loginSubmit'])
        ->name('login.store');

    // Forgot password routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // Reset password routes
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Routes accessible only to authenticated users
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Home page (task list)
    Route::get('/', [TaskController::class, 'index'])
        ->name('home');

    // Task CRUD routes (except show)
    Route::resource('tasks', TaskController::class)
        ->except('show');

    // Logout route
    Route::post('/logout', [AuthController::class, 'destroy'])
        ->name('logout');

    // Toggle task completion status
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])
        ->name('tasks.toggle');
});
