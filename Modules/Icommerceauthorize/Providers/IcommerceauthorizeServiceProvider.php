<?php

namespace Modules\Icommerceauthorize\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerceauthorize\Events\Handlers\RegisterIcommerceauthorizeSidebar;

class IcommerceauthorizeServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceauthorizeSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceauthorizes', Arr::dot(trans('icommerceauthorize::icommerceauthorizes')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommerceauthorize', 'permissions');
        $this->publishConfig('icommerceauthorize', 'config');
        $this->publishConfig('icommerceauthorize', 'crud-fields');

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
            'Modules\Icommerceauthorize\Repositories\IcommerceAuthorizeRepository',
            function () {
                $repository = new \Modules\Icommerceauthorize\Repositories\Eloquent\EloquentIcommerceAuthorizeRepository(new \Modules\Icommerceauthorize\Entities\IcommerceAuthorize());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerceauthorize\Repositories\Cache\CacheIcommerceAuthorizeDecorator($repository);
            }
        );
        // add bindings
    }
}
