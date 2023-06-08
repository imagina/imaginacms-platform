<?php

namespace Modules\Isite\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\IpUtils;

class CheckIp
{
    public function handle($request, Closure $next)
    {

        $ipsAllowed = config('asgard.isite.config.ipsAllowed');

        //Only error if is wrong ip
        if (!empty($ipsAllowed) && !IpUtils::checkIp($request->ip(),$ipsAllowed))
             throw new \Exception("IP not allowed");
           
        return $next($request);
    
    }
}
