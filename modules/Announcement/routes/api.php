<?php

use Illuminate\Support\Facades\Route;
use Modules\Announcement\Http\Controllers\API\AnnouncementController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('{announcement}')->group(function () {
        Route::get('', [AnnouncementController::class, 'show'])->name('show');
        Route::put('', [AnnouncementController::class, 'update'])->name('update');
        Route::delete('', [AnnouncementController::class, 'destroy'])->name('destroy');
    });
});
