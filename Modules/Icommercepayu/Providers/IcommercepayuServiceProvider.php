<?php

namespace Modules\Icommercepayu\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
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
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommercepayuSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommercepayus', Arr::dot(trans('icommercepayu::icommercepayus')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('icommercepayu', 'permissions');
        $this->publishConfig('icommercepayu', 'config');
        $this->publishConfig('icommercepayu', 'crud-fields');

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
