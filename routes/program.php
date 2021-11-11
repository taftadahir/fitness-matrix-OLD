<?php

use App\Http\Controllers\API\ProgramController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/programs', [ProgramController::class, 'store'])
            ->name('program.store');

        Route::get('/programs/{program}', [ProgramController::class, 'show'])
            ->name('program.show');

        Route::put('/programs/{program}', [ProgramController::class, 'update'])
            ->name('program.update');
    }
);
