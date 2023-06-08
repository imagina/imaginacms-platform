<?php

namespace Modules\Idocs\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Events\DocumentWasDownloaded;
use Modules\Idocs\Events\DocumentWasUpdated;
use Modules\Idocs\Events\Handlers\SendDocument;
use Modules\Idocs\Events\Handlers\SyncUsersInDocument;
use Modules\Idocs\Events\Handlers\TrackingDocument;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
      DocumentWasCreated::class=>[
        //SendDocument::class,
        SyncUsersInDocument::class
      ],
      DocumentWasUpdated::class => [
        SyncUsersInDocument::class
      ],
      DocumentWasDownloaded::class=>[
        TrackingDocument::class,
      ]
    ];
}