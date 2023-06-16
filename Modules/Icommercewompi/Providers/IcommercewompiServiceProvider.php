<?php

namespace Modules\Icommercewompi\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercewompi\Events\Handlers\RegisterIcommercewompiSidebar;

class IcommercewompiServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercewompiSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercewompis', Arr::dot(trans('icommercewompi::icommercewompis')));
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('icommercewompi', 'permissions');
        $this->publishConfig('icommercewompi', 'config');
        $this->publishConfig('icommercewompi', 'crud-fields');

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
            'Modules\Icommercewompi\Repositories\IcommerceWompiRepository',
            function () {
                $repository = new \Modules\Icommercewompi\Repositories\Eloquent\EloquentIcommerceWompiRepository(new \Modules\Icommercewompi\Entities\IcommerceWompi());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercewompi\Repositories\Cache\CacheIcommerceWompiDecorator($repository);
            }
        );
        // add bindings
    }
}
