<?php

use Illuminate\Support\Facades\Route;
use Modules\Classroom\Http\Controllers\API\ClassroomController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('', [ClassroomController::class, 'index'])->name('index');
    Route::get('{classroom}', [ClassroomController::class, 'show'])->name('show');


    Route::apiResource('classrooms', ClassroomController::class);
});
