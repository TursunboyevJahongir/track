<?php

use App\Filament\Pages\MyProfile;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\PhoneVerify;
use App\Http\Controllers\Auth\{FacebookController, GoogleController};
use App\Http\Livewire\Verify;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::prefix('auth/google')
        ->controller(GoogleController::class)
        ->group(function () {
            Route::get('/', 'redirectToGoogle')->name('auth.google');
            Route::get('/callback', 'handleGoogleCallback');
        });

    Route::prefix('facebook')
        ->name('facebook.')
        ->controller(FacebookController::class)
        ->group(function () {
            Route::get('auth', 'loginUsingFacebook')->name('login');
            Route::get('callback', 'callbackFromFacebook')->name('callback');
        });
});


Route::middleware('auth')->group(function () {
    Route::redirect('/', '/')->name('home');
    Route::get('my-profile', MyProfile::class)
        ->name('filament.pages.my-profile');
    Route::get('verify', Verify::class)->name('verify')
        ->withoutMiddleware([PhoneVerify::class, IsActive::class]);
});
