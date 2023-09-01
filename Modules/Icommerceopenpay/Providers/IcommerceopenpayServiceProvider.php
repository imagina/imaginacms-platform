<?php

namespace Modules\Icommerceopenpay\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerceopenpay\Events\Handlers\RegisterIcommerceopenpaySidebar;

class IcommerceopenpayServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceopenpaySidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('icommerceopenpays', Arr::dot(trans('icommerceopenpay::icommerceopenpays')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->publishConfig('icommerceopenpay', 'permissions');
        $this->publishConfig('icommerceopenpay', 'config');
        $this->publishConfig('icommerceopenpay', 'crud-fields');

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
            'Modules\Icommerceopenpay\Repositories\IcommerceOpenpayRepository',
            function () {
                $repository = new \Modules\Icommerceopenpay\Repositories\Eloquent\EloquentIcommerceOpenpayRepository(new \Modules\Icommerceopenpay\Entities\IcommerceOpenpay());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerceopenpay\Repositories\Cache\CacheIcommerceOpenpayDecorator($repository);
            }
        );
        // add bindings
    }
}
