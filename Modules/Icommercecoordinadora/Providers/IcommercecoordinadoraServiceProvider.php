<?php

namespace Modules\Icommercecoordinadora\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icommercecoordinadora\Events\Handlers\RegisterIcommercecoordinadoraSidebar;

class IcommercecoordinadoraServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercecoordinadoraSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercecoordinadoras', Arr::dot(trans('icommercecoordinadora::icommercecoordinadoras')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icommercecoordinadora', 'permissions');
        $this->publishConfig('icommercecoordinadora', 'config');
        $this->publishConfig('icommercecoordinadora', 'crud-fields');

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
            'Modules\Icommercecoordinadora\Repositories\IcommerceCoordinadoraRepository',
            function () {
                $repository = new \Modules\Icommercecoordinadora\Repositories\Eloquent\EloquentIcommerceCoordinadoraRepository(new \Modules\Icommercecoordinadora\Entities\IcommerceCoordinadora());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercecoordinadora\Repositories\Cache\CacheIcommerceCoordinadoraDecorator($repository);
            }
        );
// add bindings

    }
}
