<?php

use App\Livewire\ProjectDetails;
use App\Livewire\ProjectList;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/projects', ProjectList::class)->name('projects.index');
    Route::get('/projects/{id}', ProjectDetails::class)->name('projects.show');
});
