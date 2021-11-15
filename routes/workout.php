<?php

use App\Http\Controllers\API\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum', 'prefix' => 'workouts', 'as' => 'workout.'],
    function () {
        Route::post('', [WorkoutController::class, 'store'])
            ->name('store');
    }
);
