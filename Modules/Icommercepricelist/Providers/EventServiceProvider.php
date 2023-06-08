<?php

namespace Modules\Icommercepricelist\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icommercepricelist\Events\Handlers\UpdatePriceProductLists;
use Modules\Icommercepricelist\Events\Handlers\RefreshProductPriceLists;
use Modules\Icommerce\Events\ProductListWasCreated;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductListWasCreated::class => [
            UpdatePriceProductLists::class,
        ],
        ProductWasCreated::class => [
            RefreshProductPriceLists::class,
        ],
        ProductWasUpdated::class => [
            RefreshProductPriceLists::class,
        ],

    ];
}
