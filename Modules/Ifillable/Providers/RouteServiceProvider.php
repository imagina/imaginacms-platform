<?php

namespace Modules\Ifillable\Providers;

use Modules\Core\Providers\RoutingServiceProvider as CoreRoutingServiceProvider;

class RouteServiceProvider extends CoreRoutingServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Modules\Ifillable\Http\Controllers';

    protected function getFrontendRoute(): string
    {
        return false;
    }

    protected function getBackendRoute(): string
    {
        return false;
    }

    protected function getApiRoute(): string
    {
        return __DIR__.'/../Http/apiRoutes.php';
    }
}
