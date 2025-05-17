<?php

use Illuminate\Support\Facades\Route;
use Modules\Attachment\Http\Controllers\API\AttachmentController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('', [AttachmentController::class, 'store'])->name('store');

    Route::prefix('{attachment}')->group(function () {
        Route::get('', [AttachmentController::class, 'show'])->name('show');
        Route::delete('', [AttachmentController::class, 'destroy'])->name('destroy');
    });
});
