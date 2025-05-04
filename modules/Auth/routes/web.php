<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'Response generated from modules/Auth/routes/web.php')->name('index');
