<?php

use Illuminate\Support\Facades\Route;
use Modules\Assignment\Http\Controllers\API\AssignmentController;
use Modules\Assignment\Http\Controllers\API\MySubmissionController;
use Modules\Assignment\Http\Controllers\API\SubmissionController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('{assignment}')->group(function () {
        Route::get('', [AssignmentController::class, 'show'])->name('show');
        Route::put('', [AssignmentController::class, 'update'])->name('update');
        Route::delete('', [AssignmentController::class, 'destroy'])->name('destroy');

        Route::prefix('submissions')->name('submissions.')->group(function () {
            Route::get('', [SubmissionController::class, 'index'])->name('index');

            Route::prefix('{submission}')->group(function () {
                Route::get('', [SubmissionController::class, 'show'])->name('show');
                Route::put('', [SubmissionController::class, 'update'])->name('update');
            });
        });

        Route::prefix('my-submission')->name('my-submission.')->group(function () {
            Route::get('', [MySubmissionController::class, 'show'])->name('show');
            Route::put('', [MySubmissionController::class, 'update'])->name('update');
        });
    });
});
