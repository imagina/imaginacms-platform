<?php

namespace Modules\Icommercepayu\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommercepayu\Events\Handlers\RegisterIcommercepayuSidebar;

class IcommercepayuServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercepayuSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercepayus', Arr::dot(trans('icommercepayu::icommercepayus')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommercepayu', 'permissions');
        $this->publishConfig('icommercepayu', 'config');
        $this->publishConfig('icommercepayu', 'crud-fields');

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
            'Modules\Icommercepayu\Repositories\IcommercePayuRepository',
            function () {
                $repository = new \Modules\Icommercepayu\Repositories\Eloquent\EloquentIcommercePayuRepository(new \Modules\Icommercepayu\Entities\IcommercePayu());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommercepayu\Repositories\Cache\CacheIcommercePayuDecorator($repository);
            }
        );
        // add bindings
    }
}
