<?php

namespace Modules\Icommerceflatrate\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerceflatrate\Events\Handlers\RegisterIcommerceflatrateSidebar;

class IcommerceflatrateServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceflatrateSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceflatrates', Arr::dot(trans('icommerceflatrate::icommerceflatrates')));
            // append translations
        });
    }

    public function boot()
    {
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerceflatrate', 'permissions'), 'asgard.icommerceflatrate.permissions');
        $this->publishConfig('icommerceflatrate', 'config');
        $this->publishConfig('icommerceflatrate', 'crud-fields');

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
            'Modules\Icommerceflatrate\Repositories\IcommerceFlatrateRepository',
            function () {
                $repository = new \Modules\Icommerceflatrate\Repositories\Eloquent\EloquentIcommerceFlatrateRepository(new \Modules\Icommerceflatrate\Entities\IcommerceFlatrate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerceflatrate\Repositories\Cache\CacheIcommerceFlatrateDecorator($repository);
            }
        );
        // add bindings
    }
}
