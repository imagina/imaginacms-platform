<?php

namespace Modules\User\Http\Middleware;

use Modules\User\Contracts\Authentication;

/**
 * Class LoggedInMiddleware
 */
class LoggedInMiddleware
{
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if ($this->auth->check() === false) {
            return redirect()->route(config('asgard.user.config.redirect_route_not_logged_in', 'login'));
        }

        return $next($request);
    }
}
