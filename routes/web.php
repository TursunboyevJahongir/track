<?php

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Auth\VerifyPhone;
use App\Filament\Pages\MyProfile;
use App\Http\Middleware\IsActive;
use App\Http\Middleware\PhoneVerify;
use App\Http\Controllers\Auth\{FacebookController, GoogleController};
use App\Http\Livewire\Verify;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\MirrorConfigToSubpackages;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::middleware([
    DispatchServingFilamentEvent::class,
    MirrorConfigToSubpackages::class,
])->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('verify-phone', VerifyPhone::class)->name('verify-phone');
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


// Route::middleware('auth')->group(function () {
//     Route::get('my-profile', MyProfile::class)
//         ->name('filament.pages.my-profile');
//     Route::get('verify', Verify::class)->name('verify')
//         ->withoutMiddleware([PhoneVerify::class, IsActive::class]);
// });
