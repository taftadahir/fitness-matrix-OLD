<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('user.register');

Route::post('/login', [LoginController::class, 'store'])
    ->name('user.login');

// Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
