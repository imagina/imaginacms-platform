<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AsgardInstalledMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if (! file_exists(base_path('.env')) || ! Schema::hasTable('users')) {
            throw new \Exception('Asgard is not yet installed');
        }

        return $next($request);
    }
}
