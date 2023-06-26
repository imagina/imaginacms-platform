<?php

namespace Modules\Ibinnacle\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ibinnacle\Listeners\RegisterIbinnacleSidebar;

class IbinnacleServiceProvider extends ServiceProvider
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
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIbinnacleSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('ibinnacle', 'config');
        $this->publishConfig('ibinnacle', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibinnacle', 'settings'), 'asgard.ibinnacle.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibinnacle', 'settings-fields'), 'asgard.ibinnacle.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibinnacle', 'permissions'), 'asgard.ibinnacle.permissions');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Ibinnacle\Repositories\BinnacleRepository',
            function () {
                $repository = new \Modules\Ibinnacle\Repositories\Eloquent\EloquentBinnacleRepository(new \Modules\Ibinnacle\Entities\Binnacle());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibinnacle\Repositories\Cache\CacheBinnacleDecorator($repository);
            }
        );
        // add bindings
    }
}
