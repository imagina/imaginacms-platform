<?php

namespace Modules\Iplaces\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Iplaces\Events\CategoryWasCreated;
use Modules\Iplaces\Events\CategoryWasDeleted;
use Modules\Iplaces\Events\ServiceWasCreated;
use Modules\Iplaces\Events\ServiceWasDeleted;
use Modules\Iplaces\Events\Handlers\DeleteCategoryImage;
use Modules\Iplaces\Events\Handlers\SaveCategoryImage;
use Modules\Iplaces\Events\Handlers\SaveServiceImage;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Events\Handlers\SavePlaceImage;
use Modules\Iplaces\Events\SpaceWasCreated;
use Modules\Iplaces\Events\SpaceWasDeleted;
use Modules\Iplaces\Events\Handlers\SaveSpaceImage;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CategoryWasCreated::class => [
           SaveCategoryImage::class,
        ],
        CategoryWasDeleted::class=>[
            DeleteCategoryImage::class,
        ],
        PlaceWasCreated::class => [
            SavePlaceImage::class,
        ],
        PlaceWasDeleted::class => [
            SavePlaceImage::class,
        ],
        ServiceWasCreated::class => [
            SaveServiceImage::class,
        ],
        ServiceWasDeleted::class => [
            SaveServiceImage::class,
        ],
        SpaceWasCreated::class => [
            SaveSpaceImage::class,
        ],
        SpaceWasDeleted::class => [
            SaveSpaceImage::class,
        ],

    ];
}