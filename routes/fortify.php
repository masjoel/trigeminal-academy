<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::group(['middleware' => config('fortify.middleware', ['web']), 'namespace' => null], function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest'])
        ->name('login.post');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware(['guest', 'web'])
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
->middleware(['guest', 'web'])
->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
->middleware(['guest', 'web'])
->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
->middleware(['guest', 'web'])
->name('password.update');
