<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneVerify
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->phone_confirmed) {
            return redirect(route('verify'));
        }

        return $next($request);
    }
}
