<?php

namespace Modules\Iad\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iad\Listeners\RegisterIadSidebar;

class IadServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIadSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', Arr::dot(trans('iad::categories')));
            $event->load('ads', Arr::dot(trans('iad::ads')));
            $event->load('fields', Arr::dot(trans('iad::fields')));
            $event->load('schedules', Arr::dot(trans('iad::schedules')));
            $event->load('ups', Arr::dot(trans('iad::ups')));
            $event->load('adups', Arr::dot(trans('iad::adups')));
            $event->load('uplogs', Arr::dot(trans('iad::uplogs')));
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('iad', 'permissions');
        $this->publishConfig('iad', 'config');
        $this->publishConfig('iad', 'crud-fields');
        $this->publishConfig('iad', 'settings');
        $this->publishConfig('iad', 'settings-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iad', 'settings'), 'asgard.iad.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iad', 'settings-fields'), 'asgard.iad.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iad', 'cmsPages'), 'asgard.iad.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iad', 'cmsSidebar'), 'asgard.iad.cmsSidebar');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->registerComponents();
        $this->registerComponentsLivewire();
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
            'Modules\Iad\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iad\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\AdRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentAdRepository(new \Modules\Iad\Entities\Ad());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheAdDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Iad\Entities\Field());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\ScheduleRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentScheduleRepository(new \Modules\Iad\Entities\Schedule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheScheduleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\UpRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentUpRepository(new \Modules\Iad\Entities\Up());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheUpDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\AdUpRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentAdUpRepository(new \Modules\Iad\Entities\AdUp());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheAdUpDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iad\Repositories\UpLogRepository',
            function () {
                $repository = new \Modules\Iad\Repositories\Eloquent\EloquentUpLogRepository(new \Modules\Iad\Entities\UpLog());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iad\Repositories\Cache\CacheUpLogDecorator($repository);
            }
        );
        // add bindings
    }

    /**
     * Register components Blade
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Iad\View\Components", 'iad');
    }

    /**
     * Register components Livewire
     */
    private function registerComponentsLivewire()
    {
        Livewire::component('iad::buy-up', \Modules\Iad\Http\Livewire\AdUpForm::class);
    }
}
