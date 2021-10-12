<?php

namespace Modules\Iblog\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Iblog\Console\MigrateIblog;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Entities\Post;
use Modules\Iblog\Events\Handlers\RegisterIblogSidebar;
use Modules\Iblog\Repositories\Cache\CacheCategoryDecorator;
use Modules\Iblog\Repositories\Cache\CachePostDecorator;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\Eloquent\EloquentCategoryRepository;
use Modules\Iblog\Repositories\Eloquent\EloquentPostRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Tag\Repositories\TagManager;
use Illuminate\Support\Facades\Blade;
use Modules\Iblog\View\Components\Timeline;

class IblogServiceProvider extends ServiceProvider
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
    $this->app['events']->listen(BuildingSidebar::class, RegisterIblogSidebar::class);
    $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
      $event->load('post', Arr::dot(trans('iblog::post')));
      $event->load('category', Arr::dot(trans('iblog::category')));
      // append translations
    });
    $this->registerCommands();
  }
  
  public function boot()
  {
    $this->publishConfig('iblog', 'config');
    $this->mergeConfigFrom($this->getModuleConfigFilePath('iblog', 'settings'), "asgard.iblog.settings");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('iblog', 'settings-fields'), "asgard.iblog.settings-fields");
    $this->mergeConfigFrom($this->getModuleConfigFilePath('iblog', 'permissions'), "asgard.iblog.permissions");
    $this->publishConfig('iblog', 'crud-fields');
    
    $this->app[TagManager::class]->registerNamespace(new Post());
    
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
    $this->app->bind(PostRepository::class, function () {
      $repository = new EloquentPostRepository(new Post());
      
      if (config('app.cache') === false) {
        return $repository;
      }
      
      return new CachePostDecorator($repository);
    });
    
    $this->app->bind(CategoryRepository::class, function () {
      $repository = new EloquentCategoryRepository(new Category());
      
      if (config('app.cache') === false) {
        return $repository;
      }
      
      return new CacheCategoryDecorator($repository);
    });
    
  }
  
  /**
   * Register all commands for this module
   */
  private function registerCommands()
  {
    $this->registerMigrateIblogCommand();
  }
  
  /**
   * Register the refresh thumbnails command
   */
  private function registerMigrateIblogCommand()
  {
    
    $this->app['command.iblog.migrateiblog'] = $this->app->make(MigrateIblog::class);;
    $this->commands(['command.iblog.migrateiblog']);
  }
  
  
  /**
   * Register components
   */
  
  private function registerComponents()
  {
    Blade::componentNamespace("Modules\Iblog\View\Components", 'iblog');
  }
  
}
