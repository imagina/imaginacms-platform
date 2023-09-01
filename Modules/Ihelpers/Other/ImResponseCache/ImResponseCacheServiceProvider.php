<?php

namespace Modules\Ihelpers\Other\ImResponseCache;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Modules\Ihelpers\Other\ImResponseCache\Middlewares\ImResponseCacheMiddleware as ResponseCacheMiddleware;
use Spatie\ResponseCache\CacheProfiles\CacheProfile;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponseMiddleware;

class ImResponseCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/resources/config/laravel-responsecache.php' => config_path('laravel-responsecache.php'),
        ], 'config');

        $this->app->bind(CacheProfile::class, function (Application $app) {
            return $app->make(config('laravel-responsecache.cacheProfile'));
        });

        $this->app->singleton('laravel-responsecache', ImResponseCache::class);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/resources/config/laravel-responsecache.php', 'laravel-responsecache');

        $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependMiddleware(ResponseCacheMiddleware::class);
        $this->app[\Illuminate\Routing\Router::class]->middleware('doNotCacheResponse', DoNotCacheResponseMiddleware::class);
    }
}
