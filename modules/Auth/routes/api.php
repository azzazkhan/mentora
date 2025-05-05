<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\API\Auth\AuthenticatedSessionController;
use Modules\Auth\Http\Controllers\API\Auth\EmailVerificationNotificationController;
use Modules\Auth\Http\Controllers\API\Auth\NewPasswordController;
use Modules\Auth\Http\Controllers\API\Auth\PasswordResetLinkController;
use Modules\Auth\Http\Controllers\API\Auth\RegisteredUserController;
use Modules\Auth\Http\Controllers\API\Auth\VerifyEmailController;

Route::middleware('guest')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
