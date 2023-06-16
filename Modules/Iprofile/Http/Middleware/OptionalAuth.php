<?php

namespace Modules\Iprofile\Http\Middleware;

use Closure;

class OptionalAuth
{
    public function handle($request, Closure $next, ...$guards)
    {
        //Add optional guard API
        \Auth::shouldUse('api');

        //Response
        return $next($request);
    }
}
