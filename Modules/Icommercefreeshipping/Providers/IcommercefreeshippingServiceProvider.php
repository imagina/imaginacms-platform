<?php

namespace Modules\Icommercefreeshipping\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercefreeshipping\Events\Handlers\RegisterIcommercefreeshippingSidebar;

class IcommercefreeshippingServiceProvider extends ServiceProvider
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
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercefreeshippingSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercefreeshippings', Arr::dot(trans('icommercefreeshipping::icommercefreeshippings')));
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('icommercefreeshipping', 'permissions');
        $this->publishConfig('icommercefreeshipping', 'config');

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
            'Modules\Icommercefreeshipping\Repositories\IcommerceFreeshippingRepository',
            function () {
                $repository = new \Modules\Icommercefreeshipping\Repositories\Eloquent\EloquentIcommerceFreeshippingRepository(new \Modules\Icommercefreeshipping\Entities\IcommerceFreeshipping());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercefreeshipping\Repositories\Cache\CacheIcommerceFreeshippingDecorator($repository);
            }
        );
        // add bindings
    }
}
