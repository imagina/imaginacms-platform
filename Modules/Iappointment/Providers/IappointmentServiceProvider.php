<?php

namespace Modules\Iappointment\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iappointment\Listeners\RegisterIappointmentSidebar;

class IappointmentServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIappointmentSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('appointments', Arr::dot(trans('iappointment::appointments')));
            $event->load('categories', Arr::dot(trans('iappointment::categories')));
            $event->load('appointmentfields', Arr::dot(trans('iappointment::appointmentfields')));
            $event->load('appointmentstatuses', Arr::dot(trans('iappointment::appointmentstatuses')));
            $event->load('categoryforms', Arr::dot(trans('iappointment::categoryforms')));
            $event->load('providers', Arr::dot(trans('iappointment::providers')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('iappointment', 'config');
        $this->publishConfig('iappointment', 'crud-fields');
        $this->publishConfig('iappointment', 'permissions');
        $this->publishConfig('iappointment', 'settings');
        $this->publishConfig('iappointment', 'settings-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('iappointment', 'cmsPages'), 'asgard.iappointment.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('iappointment', 'cmsSidebar'), 'asgard.iappointment.cmsSidebar');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
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
            'Modules\Iappointment\Repositories\AppointmentRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentAppointmentRepository(new \Modules\Iappointment\Entities\Appointment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheAppointmentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iappointment\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Iappointment\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iappointment\Repositories\AppointmentStatusRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentAppointmentStatusRepository(new \Modules\Iappointment\Entities\AppointmentStatus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheAppointmentStatusDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iappointment\Repositories\ProviderRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentProviderRepository(new \Modules\Iappointment\Entities\Provider());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheProviderDecorator($repository);
            }
        );
        // add bindings

        $this->app->bind(
            'Modules\Iappointment\Repositories\AppointmentStatusHistoryRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentAppointmentStatusHistoryRepository(new \Modules\Iappointment\Entities\AppointmentStatus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheAppointmentStatusHistoryDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Iappointment\Repositories\AppointmentLeadRepository',
            function () {
                $repository = new \Modules\Iappointment\Repositories\Eloquent\EloquentAppointmentLeadRepository(new \Modules\Iappointment\Entities\AppointmentLead());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Iappointment\Repositories\Cache\CacheAppointmentLeadDecorator($repository);
            }
        );
    }

    /**
     * Register Blade components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Iappointment\View\Components", 'iappointment');
    }
}
