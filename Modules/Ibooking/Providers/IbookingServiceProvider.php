<?php

namespace Modules\Ibooking\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ibooking\Console\CheckStatusReservations;
use Modules\Ibooking\Listeners\RegisterIbookingSidebar;

class IbookingServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIbookingSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });

        $this->registerCommands();
    }

    public function boot(): void
    {
        $this->publishConfig('ibooking', 'config');
        $this->publishConfig('ibooking', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibooking', 'settings'), 'asgard.ibooking.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibooking', 'settings-fields'), 'asgard.ibooking.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibooking', 'permissions'), 'asgard.ibooking.permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibooking', 'cmsPages'), 'asgard.ibooking.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ibooking', 'cmsSidebar'), 'asgard.ibooking.cmsSidebar');

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

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerCheckStatusReservationsCommand();
    }

    private function registerCheckStatusReservationsCommand()
    {
        $this->app['command.ibooking.check-status-reservations'] = $this->app->make(CheckStatusReservations::class);
        $this->commands(['command.ibooking.check-status-reservations']);
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Ibooking\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Ibooking\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Ibooking\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibooking\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ibooking\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Ibooking\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Ibooking\Entities\Service());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibooking\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ibooking\Repositories\ResourceRepository',
            function () {
                $repository = new \Modules\Ibooking\Repositories\Eloquent\EloquentResourceRepository(new \Modules\Ibooking\Entities\Resource());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibooking\Repositories\Cache\CacheResourceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ibooking\Repositories\ReservationRepository',
            function () {
                $repository = new \Modules\Ibooking\Repositories\Eloquent\EloquentReservationRepository(new \Modules\Ibooking\Entities\Reservation());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibooking\Repositories\Cache\CacheReservationDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ibooking\Repositories\ReservationItemRepository',
            function () {
                $repository = new \Modules\Ibooking\Repositories\Eloquent\EloquentReservationItemRepository(new \Modules\Ibooking\Entities\ReservationItem());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ibooking\Repositories\Cache\CacheReservationItemDecorator($repository);
            }
        );
        // add bindings
    }
}
