<?php

use App\Filament\Pages\MyProfile;
use App\Http\Controllers\Auth\{FacebookController, GoogleController};
use App\Http\Livewire\Verify;
use Illuminate\Support\Facades\Route;

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
Route::get('verify', Verify::class)->name('verify');

Route::group(['middleware' => 'auth'], function () {
    Route::get('my-profile', MyProfile::class)->name('filament.pages.my-profile');
});

