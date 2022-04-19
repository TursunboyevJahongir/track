<?php

namespace App\Filament\Pages;

use Closure;
use Filament\Pages\Dashboard as PagesDashboard;
use Illuminate\Support\Facades\Route;

class Dashboard extends PagesDashboard
{
    public static function getRoutes(): Closure
    {
        return function () {
            Route::get('/home', static::class)->name(static::getSlug());
        };
    }
}
