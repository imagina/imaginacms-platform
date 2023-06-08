<?php

namespace Modules\Igamification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Igamification\Events\ActivityWasCompleted;
use Modules\Igamification\Events\ActivityIsIncompleted;
use Modules\Igamification\Events\CategoryWasCompleted;

use Modules\Igamification\Events\Handlers\AddActivityUser;
use Modules\Igamification\Events\Handlers\DeleteActivityUser;
use Modules\Igamification\Events\Handlers\AddCategoryUser;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [

    ActivityWasCompleted::class => [
      AddActivityUser::class
    ],
    ActivityIsIncompleted::class => [
      DeleteActivityUser::class
    ],
    CategoryWasCompleted::class => [
      AddCategoryUser::class
    ],
  ];
}
