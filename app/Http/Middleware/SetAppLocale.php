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
        $locale = config('app.main_locale');
        if ($request->session('locale') &&
            array_key_exists($request->session()->get('locale'), AvailableLocalesEnum::toArray())) {
            $locale = $request->session()->get('locale');
        }
        app()->setLocale($locale);

        return $next($request);
    }
}
