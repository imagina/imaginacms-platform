<?php

namespace Modules\Icurrency\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Icurrency\Support\Facades\Currency;

class CurrencyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $setting = json_decode($request->setting);
        if (isset($setting->currency)) {
            Currency::setLocaleCurrency($setting->currency);

            return $next($request);
        }

        $filter = json_decode($request->filter);
        if (isset($filter->currency)) {
            Currency::setLocaleCurrency($filter->currency);

            return $next($request);
        }

        return $next($request);
    }
}
