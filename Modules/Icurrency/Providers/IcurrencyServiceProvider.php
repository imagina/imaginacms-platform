<?php

namespace Modules\Icurrency\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icurrency\Events\Handlers\RegisterIcurrencySidebar;

class IcurrencyServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcurrencySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('currencies', Arr::dot(trans('icurrency::currencies')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icurrency', 'permissions');

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
            'Modules\Icurrency\Repositories\CurrencyRepository',
            function () {
                $repository = new \Modules\Icurrency\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Icurrency\Entities\Currency());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icurrency\Repositories\Cache\CacheCurrencyDecorator($repository);
            }
        );
// add bindings

    }
}
