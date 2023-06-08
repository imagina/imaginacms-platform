<?php

namespace Modules\Ichat\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

// Events And Handlers
use Modules\Ichat\Events\MessageWasSaved;
use Modules\Ichat\Events\Handlers\MessageWasSavedListener;
use Modules\Ichat\Events\MessageWasRetrieved;
use Modules\Ichat\Events\Handlers\MessageWasRetrievedListener;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    MessageWasSaved::class => [
      MessageWasSavedListener::class,
    ],
    MessageWasRetrieved::class => [
      MessageWasRetrievedListener::class,
    ],
  ];
}
