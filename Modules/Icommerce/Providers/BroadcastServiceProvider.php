<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */
        require base_path('Modules/Icommerce/Http/frontendChannels.php');
    }
}
