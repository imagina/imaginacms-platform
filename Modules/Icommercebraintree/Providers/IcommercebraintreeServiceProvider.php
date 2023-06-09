<?php

namespace Modules\Icommercebraintree\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercebraintree\Events\Handlers\RegisterIcommercebraintreeSidebar;

class IcommercebraintreeServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercebraintreeSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercebraintrees', Arr::dot(trans('icommercebraintree::icommercebraintrees')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommercebraintree', 'permissions');
        $this->publishConfig('icommercebraintree', 'config');
        $this->publishConfig('icommercebraintree', 'crud-fields');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommercebraintree\Repositories\IcommerceBraintreeRepository',
            function () {
                $repository = new \Modules\Icommercebraintree\Repositories\Eloquent\EloquentIcommerceBraintreeRepository(new \Modules\Icommercebraintree\Entities\IcommerceBraintree());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercebraintree\Repositories\Cache\CacheIcommerceBraintreeDecorator($repository);
            }
        );
        // add bindings
    }
}
