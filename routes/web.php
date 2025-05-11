<?php

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::name('dashboard.')->group(function () {

            Route::resource('users', UserController::class);
        });
    });
});

Route::get('login', fn() => response()->redirectToRoute('auth::login'))->name('login');

require __DIR__ . '/settings.php';
