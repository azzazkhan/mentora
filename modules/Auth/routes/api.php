<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => ['message' => 'Response generated from modules/Auth/routes/api.php'])->name('index');
