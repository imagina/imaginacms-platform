<?php

namespace Modules\Iblog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Iblog\Events\CategoryWasCreated;
use Modules\Iblog\Events\CategoryWasDeleted;
use Modules\Iblog\Events\Handlers\DeleteCategoryImage;
use Modules\Iblog\Events\Handlers\SaveCategoryImage;
use Modules\Iblog\Events\Handlers\SavePostImage;
use Modules\Iblog\Events\PostWasCreated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];
}