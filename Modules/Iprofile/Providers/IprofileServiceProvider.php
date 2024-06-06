<?php

namespace Modules\Iprofile\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iprofile\Events\Handlers\RegisterIprofileSidebar;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelCartalyst;
use Modules\Iprofile\Http\Middleware\AuthCan;
use Modules\Iprofile\Http\Middleware\SettingMiddleware;

class IprofileServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    protected $middleware = [
        'setting-can' => SettingMiddleware::class,
        'auth-can' => AuthCan::class,
    ];
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIprofileSidebar::class);
        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('fields', Arr::dot(trans('iprofile::fields')));
            $event->load('addresses', Arr::dot(trans('iprofile::addresses')));
            $event->load('departments', Arr::dot(trans('iprofile::departments')));
            $event->load('settings', Arr::dot(trans('iprofile::settings')));
            $event->load('userdepartments', Arr::dot(trans('iprofile::userdepartments')));
        });
    }

    public function boot()
    {
        $this->registerMiddleware();
        $this->publishConfig('iprofile', 'config');
        $this->publishConfig('iprofile', 'permissions');
        $this->publishConfig('iprofile', 'settings');
        $this->publishConfig('iprofile', 'settings-fields');
        $this->publishConfig('iprofile', 'crud-fields');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->registerComponents();
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
            'Modules\Iprofile\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Iprofile\Entities\Field());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\AddressRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentAddressRepository(new \Modules\Iprofile\Entities\Address());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheAddressDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\DepartmentRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentDepartmentRepository(new \Modules\Iprofile\Entities\Department());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheDepartmentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\SettingRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentSettingRepository(new \Modules\Iprofile\Entities\Setting());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheSettingDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\UserDepartmentRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentUserDepartmentRepository(new \Modules\Iprofile\Entities\UserDepartment());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheUserDepartmentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\RoleApiRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentRoleApiRepository(new \Modules\Iprofile\Entities\Role());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheRoleApiDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Iprofile\Repositories\UserApiRepository',
            function () {
                $repository = new \Modules\Iprofile\Repositories\Eloquent\EloquentUserApiRepository(new \Modules\User\Entities\Sentinel\User());
                if (!config('app.cache')) {
                    return $repository;
                }
                return new \Modules\Iprofile\Repositories\Cache\CacheUserApiDecorator($repository);
            }
        );
    }

    private function registerMiddleware()
    {
        foreach ($this->middleware as $name => $class) {
            $this->app['router']->aliasMiddleware($name, $class);
        }
    }

    /**
     * Register components Livewire
     */
    private function registerComponents()
    {
      Blade::componentNamespace("Modules\Iprofile\View\Components", 'iprofile');
    }
}
