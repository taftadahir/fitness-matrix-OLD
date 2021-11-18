<?php

use App\Http\Controllers\API\SetController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum', 'prefix' => 'sets', 'as' => 'set.'],
    function () {
        Route::post('', [SetController::class, 'store'])
            ->name('store');

        Route::get('/{set}', [SetController::class, 'show'])
            ->name('show');
    }
);
