<?php

use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'store'])
    ->name('user.register');

Route::post('/login', [LoginController::class, 'store'])
    ->name('user.login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::delete('/logout', [LogoutController::class, 'logout'])
        ->name('user.logout');

    Route::delete('/logout_from_all_devices', [LogoutController::class, 'logoutFromAllDevices'])
        ->name('user.logout_from_all_devices');

    Route::delete('/user/delete', [RegisterController::class, 'delete'])
        ->name('user.delete');
});
