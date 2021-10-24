<?php

use App\Http\Controllers\API\ExerciseController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/exercises', [ExerciseController::class, 'store'])
            ->name('exercise.store');
    }
);
