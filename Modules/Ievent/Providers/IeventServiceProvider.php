<?php

namespace Modules\Ievent\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Ievent\Events\Handlers\RegisterIeventSidebar;

class IeventServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIeventSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('categories', Arr::dot(trans('ievent::categories')));
            $event->load('recurrencedays', Arr::dot(trans('ievent::recurrencedays')));
            $event->load('events', Arr::dot(trans('ievent::events')));
            $event->load('recurrences', Arr::dot(trans('ievent::recurrences')));
            $event->load('attendants', Arr::dot(trans('ievent::attendants')));
            $event->load('comments', Arr::dot(trans('ievent::comments')));
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('ievent', 'config');
        $this->publishConfig('ievent', 'permissions');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ievent', 'cmsPages'), 'asgard.ievent.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ievent', 'cmsSidebar'), 'asgard.ievent.cmsSidebar');

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
            'Modules\Ievent\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Ievent\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ievent\Repositories\RecurrenceDayRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentRecurrenceDayRepository(new \Modules\Ievent\Entities\RecurrenceDay());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheRecurrenceDayDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ievent\Repositories\EventRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentEventRepository(new \Modules\Ievent\Entities\Event());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheEventDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ievent\Repositories\RecurrenceRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentRecurrenceRepository(new \Modules\Ievent\Entities\Recurrence());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheRecurrenceDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ievent\Repositories\AttendantRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentAttendantRepository(new \Modules\Ievent\Entities\Attendant());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheAttendantDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Ievent\Repositories\CommentRepository',
            function () {
                $repository = new \Modules\Ievent\Repositories\Eloquent\EloquentCommentRepository(new \Modules\Ievent\Entities\Comment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ievent\Repositories\Cache\CacheCommentDecorator($repository);
            }
        );
        // add bindings
    }
}
