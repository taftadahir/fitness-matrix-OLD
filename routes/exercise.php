<?php

use App\Http\Controllers\API\ExerciseController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/exercises', [ExerciseController::class, 'store'])
            ->name('exercise.store');

        Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])
            ->name('exercise.show');

        Route::put('/exercises/{exercise}', [ExerciseController::class, 'update'])
            ->name('exercise.update');

        Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])
            ->name('exercise.destroy');
    }
);
