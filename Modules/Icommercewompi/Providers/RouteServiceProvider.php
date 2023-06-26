<?php

namespace Modules\Icommercewompi\Providers;

use Modules\Core\Providers\RoutingServiceProvider as CoreRoutingServiceProvider;

class RouteServiceProvider extends CoreRoutingServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\Icommercewompi\Http\Controllers';

    /**
     * @return string
     */
    protected function getFrontendRoute(): string
    {
        return __DIR__.'/../Http/frontendRoutes.php';
    }

    /**
     * @return string
     */
    protected function getBackendRoute(): string
    {
        return __DIR__.'/../Http/backendRoutes.php';
    }

    /**
     * @return string
     */
    protected function getApiRoute(): string
    {
        return __DIR__.'/../Http/apiRoutes.php';
    }
}
