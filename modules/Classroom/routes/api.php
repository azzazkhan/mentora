<?php

use Illuminate\Support\Facades\Route;
use Modules\Announcement\Http\Controllers\API\AnnouncementController;
use Modules\Assignment\Http\Controllers\API\AssignmentController;
use Modules\Classroom\Http\Controllers\API\ClassroomController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('', [ClassroomController::class, 'index'])->name('index');
    Route::get('enrolled', [ClassroomController::class, 'enrolled'])->name('enrolled');

    Route::prefix('{classroom}')->group(function () {
        Route::get('', [ClassroomController::class, 'show'])->name('show');

        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('', [AnnouncementController::class, 'index'])->name('index');
            Route::post('', [AnnouncementController::class, 'store'])->name('store');
        });

        Route::prefix('assignments')->name('assignments.')->group(function () {
            Route::get('', [AssignmentController::class, 'index'])->name('index');
            Route::post('', [AssignmentController::class, 'store'])->name('store');
        });
    });
});
