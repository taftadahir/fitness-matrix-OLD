<?php

use App\Http\Controllers\API\UserStatController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum', 'prefix' => 'user_stats', 'as' => 'user_stat.'],
    function () {
        Route::post('', [UserStatController::class, 'store'])
            ->name('store');

        Route::put('/{userStat}', [UserStatController::class, 'update'])
            ->name('update');

        Route::get('/{userStat}', [UserStatController::class, 'show'])
            ->name('show');
    }
);
