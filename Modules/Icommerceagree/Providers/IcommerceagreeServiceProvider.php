<?php

namespace Modules\Icommerceagree\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerceagree\Events\Handlers\RegisterIcommerceagreeSidebar;

class IcommerceagreeServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceagreeSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceagrees', Arr::dot(trans('icommerceagree::icommerceagrees')));
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('icommerceagree', 'permissions');
        $this->publishConfig('icommerceagree', 'config');
        $this->publishConfig('icommerceagree', 'crud-fields');

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
            'Modules\Icommerceagree\Repositories\IcommerceAgreeRepository',
            function () {
                $repository = new \Modules\Icommerceagree\Repositories\Eloquent\EloquentIcommerceAgreeRepository(new \Modules\Icommerceagree\Entities\IcommerceAgree());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerceagree\Repositories\Cache\CacheIcommerceAgreeDecorator($repository);
            }
        );
        // add bindings
    }
}
