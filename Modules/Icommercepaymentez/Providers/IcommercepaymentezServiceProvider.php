<?php

namespace Modules\Icommercepaymentez\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icommercepaymentez\Events\Handlers\RegisterIcommercepaymentezSidebar;

class IcommercepaymentezServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercepaymentezSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercepaymentezs', Arr::dot(trans('icommercepaymentez::icommercepaymentezs')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icommercepaymentez', 'permissions');
        $this->publishConfig('icommercepaymentez', 'config');
        $this->publishConfig('icommercepaymentez', 'crud-fields');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommercepaymentez\Repositories\IcommercePaymentezRepository',
            function () {
                $repository = new \Modules\Icommercepaymentez\Repositories\Eloquent\EloquentIcommercePaymentezRepository(new \Modules\Icommercepaymentez\Entities\IcommercePaymentez());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercepaymentez\Repositories\Cache\CacheIcommercePaymentezDecorator($repository);
            }
        );
// add bindings

    }

    
}
