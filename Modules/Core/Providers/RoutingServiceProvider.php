<?php

namespace Modules\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

abstract class RoutingServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * @return string
     */
    abstract protected function getFrontendRoute();

    /**
     * @return string
     */
    abstract protected function getBackendRoute();

    /**
     * @return string
     */
    abstract protected function getApiRoute();

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->loadApiRoutes($router);

        \Route::prefix(LaravelLocalization::setLocale())->middleware('localeSessionRedirect', 'localizationRedirect', 'web')->group(function (Router $router) {
            $this->loadBackendRoutes($router);
            $this->loadFrontendRoutes($router);
        });
    }

    private function loadFrontendRoutes(Router $router)
    {
        $frontend = $this->getFrontendRoute();

        if ($frontend && file_exists($frontend)) {
            \Route::middleware(config('asgard.core.core.middleware.frontend', []))->group(function (Router $router) use ($frontend) {
                require $frontend;
            });
        }
    }

    private function loadBackendRoutes(Router $router)
    {
        $backend = $this->getBackendRoute();

        if ($backend && file_exists($backend)) {
            \Route::prefix(config('asgard.core.core.admin-prefix'))->middleware(config('asgard.core.core.middleware.backend', []))->group(function (Router $router) use ($backend) {
                require $backend;
            });
        }
    }

    private function loadApiRoutes(Router $router)
    {
        $api = $this->getApiRoute();

        if ($api && file_exists($api)) {
            \Route::prefix(LaravelLocalization::setLocale().'/api')->middleware(config('asgard.core.core.middleware.api', []))->namespace($this->namespace."\Api")->group(function (Router $router) use ($api) {
                require $api;
            });
        }
    }
}
