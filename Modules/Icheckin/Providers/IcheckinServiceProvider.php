<?php

namespace Modules\Icheckin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icheckin\Events\Handlers\RegisterIcheckinSidebar;
use Modules\Icheckin\Http\Middleware\CanCheckout;

class IcheckinServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $middleware = [
        'checkout-can' => CanCheckout::class,
    ];

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcheckinSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('jobs', array_dot(trans('icheckin::jobs')));
            $event->load('requests', array_dot(trans('icheckin::requests')));
            $event->load('shifts', array_dot(trans('icheckin::shifts')));

            $event->load('approvals', array_dot(trans('icheckin::approvals')));
            // append translations
        });
    }

    public function boot(): void
    {
        $this->registerMiddleware();
        $this->publishConfig('icheckin', 'permissions');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icheckin', 'cmsPages'), 'asgard.icheckin.cmsPages');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icheckin', 'cmsSidebar'), 'asgard.icheckin.cmsSidebar');
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
            'Modules\Icheckin\Repositories\JobRepository',
            function () {
                $repository = new \Modules\Icheckin\Repositories\Eloquent\EloquentJobRepository(new \Modules\Icheckin\Entities\Job());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icheckin\Repositories\Cache\CacheJobDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icheckin\Repositories\RequestRepository',
            function () {
                $repository = new \Modules\Icheckin\Repositories\Eloquent\EloquentRequestRepository(new \Modules\Icheckin\Entities\Request());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icheckin\Repositories\Cache\CacheRequestDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icheckin\Repositories\ShiftRepository',
            function () {
                $repository = new \Modules\Icheckin\Repositories\Eloquent\EloquentShiftRepository(new \Modules\Icheckin\Entities\Shift());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icheckin\Repositories\Cache\CacheShiftDecorator($repository);
            }
        );

        $this->app->bind(
            'Modules\Icheckin\Repositories\ApprovalRepository',
            function () {
                $repository = new \Modules\Icheckin\Repositories\Eloquent\EloquentApprovalRepository(new \Modules\Icheckin\Entities\Approvals());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icheckin\Repositories\Cache\CacheApprovalDecorator($repository);
            }
        );
        // add bindings
    }

  private function registerMiddleware()
  {
      foreach ($this->middleware as $name => $class) {
          $this->app['router']->aliasMiddleware($name, $class);
      }
  }
}
