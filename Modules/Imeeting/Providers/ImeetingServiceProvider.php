<?php

namespace Modules\Imeeting\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Imeeting\Events\Handlers\RegisterImeetingSidebar;

class ImeetingServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterImeetingSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('imeetings', Arr::dot(trans('imeeting::imeetings')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('imeeting', 'config');
        $this->publishConfig('imeeting', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('imeeting', 'settings'), 'asgard.imeeting.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('imeeting', 'settings-fields'), 'asgard.imeeting.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('imeeting', 'permissions'), 'asgard.imeeting.permissions');

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
            'Modules\Imeeting\Repositories\MeetingRepository',
            function () {
                $repository = new \Modules\Imeeting\Repositories\Eloquent\EloquentMeetingRepository(new \Modules\Imeeting\Entities\Meeting());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Imeeting\Repositories\Cache\CacheMeetingDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Imeeting\Repositories\ProviderRepository',
            function () {
                $repository = new \Modules\Imeeting\Repositories\Eloquent\EloquentProviderRepository(new \Modules\Imeeting\Entities\Provider());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Imeeting\Repositories\Cache\CacheProviderDecorator($repository);
            }
        );
        // add bindings
    }
}
