<?php

namespace Modules\Iplaces\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iplaces\Events\Handlers\RegisterIplacesSidebar;
use Illuminate\Support\Facades\Blade;

class IplacesServiceProvider extends ServiceProvider
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
          $this->app['events']->listen(BuildingSidebar::class, RegisterIplacesSidebar::class);
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('places', Arr::dot(trans('iplaces::places')));
            $event->load('categories', Arr::dot(trans('iplaces::categories')));
            $event->load('services', Arr::dot(trans('iplaces::services')));
            $event->load('zones', Arr::dot(trans('iplaces::zones')));
            $event->load('spaces', Arr::dot(trans('iplaces::spaces')));
            $event->load('cities', Arr::dot(trans('iplaces::cities')));
        });
    }

    public function boot()
    {
        $this->publishConfig('iplaces', 'permissions');
        $this->publishConfig('iplaces', 'settings');
        $this->publishConfig('iplaces', 'config');
        $this->publishConfig('iplaces', 'crud-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplaces', 'cmsPages'), "asgard.iplaces.cmsPages");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iplaces', 'cmsSidebar'), "asgard.iplaces.cmsSidebar");
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
            'Modules\Iplaces\Repositories\PlaceRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentPlaceRepository(new \Modules\Iplaces\Entities\Place());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CachePlaceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iplaces\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ServiceRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentServiceRepository(new \Modules\Iplaces\Entities\Service());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheServiceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ZoneRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentZoneRepository(new \Modules\Iplaces\Entities\Zone());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheZoneDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\ScheduleRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentScheduleRepository(new \Modules\Iplaces\Entities\Schedule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheScheduleDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Iplaces\Repositories\SpaceRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentSpaceRepository(new \Modules\Iplaces\Entities\Space());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheSpaceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iplaces\Repositories\CityRepository',
            function () {
                $repository = new \Modules\Iplaces\Repositories\Eloquent\EloquentCityRepository(new \Modules\Iplaces\Entities\City());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iplaces\Repositories\Cache\CacheCityDecorator($repository);
            }
        );
// add bindings





    }
}
