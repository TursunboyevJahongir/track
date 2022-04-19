<?php

namespace App\Http\Middleware;

use App\Core\Traits\Responsable;
use Closure;
use Illuminate\Http\Request;

class IsActive
{
    use Responsable;

    public function handle(Request $request, Closure $next): mixed
    {
        if (auth()->check() && auth()->user()->phone_confirmed && !auth()->user()->is_active) {
            return $request->expectsJson()
                ? $this->responseWith(code: 403, message: __("messages.user_not_active"))
                : abort(403, __("messages.user_not_active"));
        }

        return $next($request);
    }
}
