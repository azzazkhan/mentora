<?php

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('me', fn(Request $request) => new UserResource($request->user()))->name('me');
    });

    Route::prefix('auth')->name('auth.')->group(base_path('routes/api-auth.php'));
});
