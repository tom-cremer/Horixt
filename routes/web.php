<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

//Imports
require __DIR__ . '/auth.php';
require __DIR__ . '/track.php';
require __DIR__ . '/project.php';
require __DIR__ . '/todo.php';

// Principal views

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', \App\Livewire\Dashboard::class )
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

