<?php

namespace Modules\Isearch\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Iblog\Entities\Post;
use Modules\Isearch\Repositories\Cache\CacheSearchDecorator;
use Modules\Isearch\Repositories\Eloquent\EloquentSearchRepository;
use Modules\Isearch\Repositories\SearchRepository;

class IsearchServiceProvider extends ServiceProvider
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
    }

    public function boot()
    {
        $this->publishConfig('isearch', 'config');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isearch', 'settings'), 'asgard.isearch.settings');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isearch', 'settings-fields'), 'asgard.isearch.settings-fields');
        $this->mergeConfigFrom($this->getModuleConfigFilePath('isearch', 'permissions'), 'asgard.isearch.permissions');
        $this->registerComponentsLivewire();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(SearchRepository::class, function () {
            $repository = new EloquentSearchRepository(new Post());

            if (config('app.cache') === false) {
                return $repository;
            }

            return new CacheSearchDecorator($repository);
        });
    }

    /**
     * Register components Livewire
     */
    private function registerComponentsLivewire()
    {
        Livewire::component('isearch::search', \Modules\Isearch\Http\Livewire\Search::class);
    }
}
