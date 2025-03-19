<?php

use App\Livewire\Project;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/projects', Project::class)->name('projects');
});
