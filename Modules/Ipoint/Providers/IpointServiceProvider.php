<?php

namespace Modules\Ipoint\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ipoint\Listeners\RegisterIpointSidebar;

class IpointServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIpointSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('ipoint', 'config');
        $this->publishConfig('ipoint', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ipoint', 'settings'), 'asgard.ipoint.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ipoint', 'settings-fields'), 'asgard.ipoint.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ipoint', 'permissions'), 'asgard.ipoint.permissions');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Ipoint\Repositories\PointRepository',
            function () {
                $repository = new \Modules\Ipoint\Repositories\Eloquent\EloquentPointRepository(new \Modules\Ipoint\Entities\Point());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ipoint\Repositories\Cache\CachePointDecorator($repository);
            }
        );
        // add bindings
    }
}
