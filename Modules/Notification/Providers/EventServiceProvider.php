<?php

namespace Modules\Notification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Modules\Notification\Events\Handlers\NotificationHandler;

class EventServiceProvider extends ServiceProvider
{
    private $module;

    private $service;

    protected $listen = [];

    public function boot()
    {
        $this->module = app('modules');

        if (isset($this->module) && $this->module && $this->module->allEnabled()) {
            $this->service = app('Modules\\Notification\\Repositories\\RuleRepository');
            $notifiable = $this->service->moduleConfigs($this->module->allEnabled());

            //dd($notifiable);
            $tempListen = [];

            foreach ($notifiable as $entity) {
                foreach ($entity['events'] as $event) {
                    //Listen Creating Event
                    /* Event::listen(
                         $event["path"],
                         [NotificationHandler::class]
                     );*/

                    $listen = [$event['path'] => [
                        NotificationHandler::class,
                    ]];

                    array_push(
                        $tempListen,
                        $listen
                    );
                }
            }

            $this->listen = Arr::collapse($tempListen);
        }
    }
}
