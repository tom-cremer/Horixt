<?php


use App\Livewire\Todo;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/todos', Todo::class)->name('todos');
});
