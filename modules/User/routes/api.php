<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\API\UserController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('me')->name('me.')->group(function () {
        Route::get('', [UserController::class, 'show'])->name('show');
        Route::post('', [UserController::class, 'update'])->name('update');
    });
});
