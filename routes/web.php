<?php

use App\Livewire\Dashboard;
use App\Livewire\ProjectDetails;
use App\Livewire\ProjectList;
use App\Livewire\Todo;
use App\Livewire\Track;
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



/*Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});*/
/*
 * Route prefix /organisation -> group
 *      route prefix /{id} -> group middleware('organization')
 *          Route get /settings to component Settings
 *
 *
 * Route prefix /personal -> group middleware('personal')
 *          Route get /settings to component Settings
 * */

Route::prefix('/personal')
    ->middleware(['personal'])
    ->name('personal.')
    ->group(function () {
        Route::redirect('settings', 'settings/profile')->name('settings');
        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/tracks', Track::class)->name('tracks');
        Route::get('/todos', Todo::class)->name('todos');
        Route::get('/projects', ProjectList::class)->name('projects.index');
        Route::get('/projects/{id}', ProjectDetails::class)->name('projects.show');

    });


Route::prefix('/organization/{id}')
    ->middleware(['organization'])
    ->name('organization.')
    ->group(function () {
        Route::redirect('settings', 'settings/profile')->name('settings');
        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        Route::get('/dashboard', Dashboard::class)
            ->name('dashboard');
        Route::get('/tracks', Track::class)->name('tracks');
        Route::get('/todos', Todo::class)->name('todos');
        Route::get('/projects', ProjectList::class)->name('projects.index');
        Route::get('/projects/{projectid}', ProjectDetails::class)->name('projects.show');
    });
