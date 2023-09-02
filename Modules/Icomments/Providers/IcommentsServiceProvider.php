<?php

namespace Modules\Icomments\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icomments\Listeners\RegisterIcommentsSidebar;

class IcommentsServiceProvider extends ServiceProvider
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
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommentsSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });
    }

    public function boot()
    {
        $this->publishConfig('icomments', 'config');
        $this->publishConfig('icomments', 'crud-fields');

        $this->mergeConfigFrom($this->getModuleConfigFilePath('icomments', 'settings'), 'asgard.icomments.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icomments', 'settings-fields'), 'asgard.icomments.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('icomments', 'permissions'), 'asgard.icomments.permissions');

        //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->registerComponents();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register components
     */
    private function registerComponents()
    {
        Blade::componentNamespace("Modules\Icomments\View\Components", 'icomments');
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icomments\Repositories\CommentRepository',
            function () {
                $repository = new \Modules\Icomments\Repositories\Eloquent\EloquentCommentRepository(new \Modules\Icomments\Entities\Comment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icomments\Repositories\Cache\CacheCommentDecorator($repository);
            }
        );
        // add bindings
    }
}
