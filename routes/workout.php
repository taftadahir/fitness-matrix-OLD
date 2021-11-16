<?php

use App\Http\Controllers\API\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum', 'prefix' => 'workouts', 'as' => 'workout.'],
    function () {
        Route::post('', [WorkoutController::class, 'store'])
            ->name('store');

        Route::put('/{workout}', [WorkoutController::class, 'update'])
            ->name('update');

        Route::get('/{workout}', [WorkoutController::class, 'show'])
            ->name('show');

        Route::delete('/{workout}', [WorkoutController::class, 'destroy'])
            ->name('destroy');
    }
);
