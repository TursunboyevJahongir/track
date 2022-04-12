<?php

namespace App\Http\Middleware;

use App\Enums\AvailableLocalesEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (session()->get('locale')) {
            app()->setLocale(\session());
            dd($next);
        }
        return $next($request);
    }
}
