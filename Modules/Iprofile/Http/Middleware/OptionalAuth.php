<?php

namespace Modules\Iprofile\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\Auth\Factory as Auth;

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
