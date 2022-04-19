<?php

use App\Filament\Pages\Auth\{Login,Register};
use App\Http\Controllers\Auth\{FacebookController, GoogleController};
use App\Http\Livewire\Verify;
use Filament\Http\Middleware\{DispatchServingFilamentEvent,MirrorConfigToSubpackages};
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::middleware([
    DispatchServingFilamentEvent::class,
    MirrorConfigToSubpackages::class,
])->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('verify-phone', Verify::class)
        ->name('verify-phone')->withoutMiddleware(['is_active','phone_verify']);
});

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
