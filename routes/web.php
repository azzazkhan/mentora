<?php

use App\Livewire\Pages\Announcement;
use App\Livewire\Pages\Assignment;
use App\Livewire\Pages\Browse;
use App\Livewire\Pages\Classroom;
use App\Livewire\Pages\Dashboard;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('classrooms/{classroom}')->group(function () {
        Route::get('', Classroom::class)->name('classroom.show');
        Route::get('assignments/{assignment}', Assignment::class)->name('assignment.show');
        Route::get('announcements/{announcement}', Announcement::class)->name('announcement.show');
    });

    Route::get('explore', Browse::class)->name('browse');
});


Route::get('login', fn() => response()->redirectToRoute('auth::login'))->name('login');

// require __DIR__ . '/settings.php';
