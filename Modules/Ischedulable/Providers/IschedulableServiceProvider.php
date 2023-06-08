<?php

namespace Modules\Ischedulable\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Ischedulable\Listeners\RegisterIschedulableSidebar;

class IschedulableServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIschedulableSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {

        $this->publishConfig('ischedulable', 'config');
        $this->publishConfig('ischedulable', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ischedulable', 'settings'), "asgard.ischedulable.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ischedulable', 'settings-fields'), "asgard.ischedulable.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ischedulable', 'permissions'), "asgard.ischedulable.permissions");

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
            'Modules\Ischedulable\Repositories\DayRepository',
            function () {
                $repository = new \Modules\Ischedulable\Repositories\Eloquent\EloquentDayRepository(new \Modules\Ischedulable\Entities\Day());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ischedulable\Repositories\Cache\CacheDayDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ischedulable\Repositories\ScheduleRepository',
            function () {
                $repository = new \Modules\Ischedulable\Repositories\Eloquent\EloquentScheduleRepository(new \Modules\Ischedulable\Entities\Schedule());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ischedulable\Repositories\Cache\CacheScheduleDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ischedulable\Repositories\WorkTimeRepository',
            function () {
                $repository = new \Modules\Ischedulable\Repositories\Eloquent\EloquentWorkTimeRepository(new \Modules\Ischedulable\Entities\WorkTime());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ischedulable\Repositories\Cache\CacheWorkTimeDecorator($repository);
            }
        );
// add bindings




    }


}
