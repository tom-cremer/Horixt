<?php

use App\Livewire\Track;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/tracks', Track::class)->name('tracks');

});
