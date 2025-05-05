<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Resources\UserResource;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', fn(Request $request) => new UserResource($request->user()))->name('me');
});
