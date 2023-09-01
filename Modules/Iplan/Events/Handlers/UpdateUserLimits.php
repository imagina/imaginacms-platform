<?php

namespace Modules\Iplan\Events\Handlers;

use Carbon\Carbon;
use Modules\Iplan\Entities\EntityPlan;
use Modules\Iplan\Entities\SubscriptionLimit;

class UpdateUserLimits
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        $model = $event->model; //Get Model

        $userDriver = config('asgard.user.config.driver');

        //Get entity attributes
        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1]; //Get module name
        $entityName = $entityNamespaceExploded[3]; //Get entity name

        //Validate if entity require plan

        $requirePlan = EntityPlan::where('entity', $entityNamespace)->where('module', $moduleName)->where('status', 1)
          ->count() > 0 ? true : false;
        if ($requirePlan) {
            $userSubcriptionLimits = SubscriptionLimit::whereHas('subscription', function ($q) use ($userDriver) {
                //Get current full date
                $now = Carbon::now()->format('Y-m-d h:i:s');
                //Filter subscriptions
                $q->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use ($userDriver) {
                    $query->whereNull('entity')->orWhere(function ($query) use ($userDriver) {
                        $query->where('entity_id', auth()->user()->id)->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
                    });
                });
            })->where('entity', $entityNamespace)
              ->orderBy('id')
              ->get();

            if ($userSubcriptionLimits->count() > 0) {
                foreach ($userSubcriptionLimits as $limitToValidate) {
                    $validateLimit = true;
                    $limitAttribute = $limitToValidate->attribute; //get limit attribute name
                    //Validate if limit has attribute
                    if ($limitAttribute) {
                        $modeleValue = $model->$limitAttribute ?? null;
                        if ($modeleValue != $limitToValidate->attribute_value) {
                            $validateLimit = false;
                        }
                    }
                    //validate limit quantities
                    if ($validateLimit) {
                        $updatedQuantityUsed = $limitToValidate->quantity_used + 1; //increase subs limit quantity used by 1
                        $limitToValidate->update(['quantity_used' => $updatedQuantityUsed]); //update subs limit quantity used
                        break;
                    }
                }
            }
        }
    }
}
