<?php

use App\Livewire\Dashboard;
use App\Livewire\FileManager;
use App\Livewire\Members;
use App\Livewire\Organizations;
use App\Livewire\ProjectDetails;
use App\Livewire\ProjectList;
use App\Livewire\Todo;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

//Imports
require __DIR__ . '/auth.php';

// Principal views

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::prefix('/personal')
    ->middleware(['personal'])
    ->name('personal.')
    ->group(callback: function () {
        Route::redirect('settings', 'settings/profile')->name('settings');
        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/organizations', Organizations::class)->name('organizations');
        Route::get('/todos', Todo::class)->name('todos');
        Route::get('/projects', ProjectList::class)->name('projects.index');
        Route::get('/projects/{projectid}', ProjectDetails::class)->name('projects.show');
        Route::get('/files', FileManager::class)->name('files');

    });


Route::prefix('/organization/{slug}')
    ->middleware(['organization'])
    ->name('organization.')
    ->group(function () {
        Route::redirect('settings', 'settings/profile')->name('settings');
        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/members', Members::class)->name('members');
        Route::get('/todos', Todo::class)->name('todos');
        Route::get('/projects', ProjectList::class)->name('projects.index');
        Route::get('/projects/{projectid}', ProjectDetails::class)->name('projects.show');
        Route::get('/files', FileManager::class)->name('files');

    });
