<?php

namespace Modules\Isite\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Stancl\Tenancy\Exceptions\TenancyNotInitializedException;
use Symfony\Component\HttpFoundation\IpUtils;

class CheckTenancyForMaintenance extends CheckForMaintenanceMode
{
    public function handle($request, Closure $next)
    {

       
        if (!is_null(tenant()) && tenant('maintenance_mode')) {

            $data = tenant('maintenance_mode');

            $tpl = 'isite::frontend.errors.maintenance';
            $ttpl = 'errors.maintenance';

            if (view()->exists($ttpl)) $tpl = $ttpl;

            return view($tpl);

        }

        return $next($request);
    }
}
