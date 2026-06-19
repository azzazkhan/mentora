<?php

use App\Livewire\Pages\Announcement;
use App\Livewire\Pages\Assignment;
use App\Livewire\Pages\Browse;
use App\Livewire\Pages\Classroom;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\Livestream;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('classrooms/{classroom}/livestream', Livestream::class)->name('livestream.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('assignments/{assignment:uuid}', Assignment::class);


    Route::get('classrooms/{classroom}/assignments/{assignment}', Assignment::class)->name('assignment.show');
    Route::get('classrooms/{classroom}/announcements/{announcement:uuid}', Announcement::class)->name('announcement.show');

    Route::prefix('classrooms/{classroom:uuid}')->group(function () {
        Route::get('', Classroom::class)->name('classroom.show');
    });

    Route::get('explore', Browse::class)->name('browse');
});


Route::get('login', fn() => response()->redirectToRoute('auth::login'))->name('login');
Route::get('lorem', fn() => to_route('filament.admin.pages.dashboard'))->name('filament.admin.resources.assignments.index');

// require __DIR__ . '/settings.php';
