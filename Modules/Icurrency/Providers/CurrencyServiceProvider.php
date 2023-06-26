<?php

namespace Modules\Icurrency\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Icurrency\Support\Currency;

class CurrencyServiceProvider extends ServiceProvider
{
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
        $this->app->singleton('currency', function () {
            return new Currency();
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
