<?php

namespace Modules\Ifollow\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Ifollow\Listeners\RegisterIfollowSidebar;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

class IfollowServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterIfollowSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {

        $this->publishConfig('ifollow', 'config');
        $this->publishConfig('ifollow', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifollow', 'settings'), "asgard.ifollow.settings");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifollow', 'settings-fields'), "asgard.ifollow.settings-fields");
        $this->mergeConfigFrom($this->getModuleConfigFilePath('ifollow', 'permissions'), "asgard.ifollow.permissions");

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
        $this->registerComponentsLivewire();
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
            'Modules\Ifollow\Repositories\FollowerRepository',
            function () {
                $repository = new \Modules\Ifollow\Repositories\Eloquent\EloquentFollowerRepository(new \Modules\Ifollow\Entities\Follower());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Ifollow\Repositories\Cache\CacheFollowerDecorator($repository);
            }
        );
// add bindings

    }

    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Ifollow\View\Components", 'ifollow');
    }


    private function registerComponentsLivewire()
    {
        Livewire::component('ifollow::follow', \Modules\Ifollow\Http\Livewire\Follow::class);
        Livewire::component('ifollow::followers', \Modules\Ifollow\Http\Livewire\Followers::class);
    }
}
