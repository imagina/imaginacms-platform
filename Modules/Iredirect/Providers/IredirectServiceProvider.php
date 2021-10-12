<?php

namespace Modules\Iredirect\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Iredirect\Entities\Category;
use Modules\Iredirect\Entities\Redirect;
use Modules\Iredirect\Entities\Tag;
use Modules\Iredirect\Repositories\Cache\CacheCategoryDecorator;
use Modules\Iredirect\Repositories\Cache\CacheRedirectDecorator;
use Modules\Iredirect\Repositories\Cache\CacheTagDecorator;
use Modules\Iredirect\Repositories\CategoryRepository;
use Modules\Iredirect\Repositories\Eloquent\EloquentCategoryRepository;
use Modules\Iredirect\Repositories\Eloquent\EloquentRedirectRepository;
use Modules\Iredirect\Repositories\Eloquent\EloquentTagRepository;
use Modules\Iredirect\Repositories\RedirectRepository;
use Modules\Iredirect\Repositories\TagRepository;
use Modules\Core\Traits\CanPublishConfiguration;

class IredirectServiceProvider extends ServiceProvider
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
  }
  
  public function boot()
  {
    $this->publishConfig('iredirect', 'config');
    //$this->publishConfig('iredirect', 'settings');
    $this->mergeConfigFrom($this->getModuleConfigFilePath('iredirect', 'permissions'), "asgard.iredirect.permissions");
    
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
    $this->app->bind(RedirectRepository::class, function () {
      $repository = new EloquentRedirectRepository(new Redirect());
      
      if (config('app.cache') === false) {
        return $repository;
      }
      
      return new CacheRedirectDecorator($repository);
    });
    
  }
}
