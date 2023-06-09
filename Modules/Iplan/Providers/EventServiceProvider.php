<?php

namespace Modules\Iplan\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Iplan\Events\Handlers\HandleModulesLimits;
use Modules\Iplan\Events\Handlers\ProcessPlanOrder;
use Modules\Iplan\Events\Handlers\RegisterNewSubscription;
use Modules\Iplan\Events\Handlers\RegisterUserQr;

class EventServiceProvider extends ServiceProvider
{
    private $module;

    protected $listen = [];

    public function register()
    {
        $this->module = app('modules'); //Get modules
        $entities = []; //Default entities

        //Dynamic module events
        $dynamicModuleEvents = ['IsCreating', 'WasCreated', 'IsUpdating', 'WasUpdated', 'IsDeleting', 'WasDeleted'];

        //Get config to limits entities
        foreach ($this->module->allEnabled() as $name => $module) {
            $configLimitEntities = config('asgard.'.strtolower($name).'.config.limitableEntities');
            if (! empty($configLimitEntities)) {
                $entities = array_merge($entities, $configLimitEntities);
            }
        }

        //Create dynamic events handler
        foreach ($entities as $entity) {
            if (isset($entity['status']) && $entity['status']) {
                //Get entity information
                $entityPath = explode('\\', $entity['entity']);
                $entityName = end($entityPath);
                $moduleName = $entityPath[1];

                //Listen dynamic module events
                foreach ($dynamicModuleEvents as $eventName) {
                    Event::listen(
                        'Modules\\'.$moduleName.'\\Events\\'.$entityName.$eventName,
                        [HandleModulesLimits::class, "handle{$eventName}"]
                    );
                }
            }
        }

        //Listen user was created event
        Event::listen(
            'Modules\\Iprofile\\Events\\UserCreatedEvent',
            [RegisterNewSubscription::class, 'handle']
        );

        //Listen user was created event
        Event::listen('Modules\\User\\Events\\UserWasCreated', [RegisterUserQr::class, 'handle']);
        /*Event::listen(
          "Modules\\Iprofile\\Events\\UserCreatedEvent",
          [RegisterUserQr::class, 'handle']
        );*/

        //Listen user was created event
        //Event::listen("Modules\\User\\Events\\UserWasUpdated", [RegisterUserQr::class, 'handle']);
        /*Event::listen(
          "Modules\\Iprofile\\Events\\UserUpdatedEvent",
          [RegisterUserQr::class, 'handle']
        );*/

        if (is_module_enabled('Icommerce')) {
            //Listen order processed
            Event::listen(
                'Modules\\Icommerce\\Events\\OrderWasProcessed',
                [ProcessPlanOrder::class, 'handle']
            );
        }
    }
}
