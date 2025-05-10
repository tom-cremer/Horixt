<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Livewire\Admin\AdminDashboard;
use App\Mail\InviteEmail;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

    Volt::route('register', 'auth.register')
        ->name('register');

    Volt::route('forgot-password', 'auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'auth.reset-password')
        ->name('password.reset');

    Volt::route('hidden/superadmin/login', 'auth.superadmin-login')
        ->name('superadmin.login');


});

Route::prefix('/hidden/superadmin')
    ->middleware('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');

        Route::get('/preview/mail/invite-member', function () {
            $user = auth()->user();
            $organization = $user->organizations()->first();
            $token = 'fake-token';
            return new InviteEmail($token, $user, $organization);
        });
    });


Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'auth.confirm-password')
        ->name('password.confirm');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
