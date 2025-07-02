<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'Response generated from modules/Livestream/routes/web.php')->name('index');
