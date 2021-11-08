<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('/programs', [ProgramController::class, 'store'])
            ->name('program.store');
    }
);
