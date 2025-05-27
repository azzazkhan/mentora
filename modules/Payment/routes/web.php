<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\CheckoutController;

Route::prefix('{transaction}')
    ->middleware(['signed'])
    ->group(function () {
        Route::get('success', [CheckoutController::class, 'store'])->name('checkout.success');
        Route::get('failure', [CheckoutController::class, 'destroy'])->name('checkout.failure');
    });

// Route::get('success', fn() => view('payment::checkout.success'));
// Route::get('cancelled', fn() => view('payment::checkout.cancelled'));
// Route::get('pending', fn() => view('payment::checkout.pending'));
