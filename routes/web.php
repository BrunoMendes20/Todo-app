<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'create'])->name('register');
    Route::post('/users', [AuthController::class, 'store'])->name('users.store');

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.store');
});


Route::middleware('auth')->group(
    function () {
        Route::get('/', [TaskController::class, 'index'])->name('home');
        Route::resource('tasks', TaskController::class)->except('show');

        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    }
);
