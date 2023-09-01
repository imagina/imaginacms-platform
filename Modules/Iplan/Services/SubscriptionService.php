<?php

namespace Modules\Iplan\Services;

use Carbon\Carbon;
use Modules\Iplan\Entities\Subscription;

class SubscriptionService
{
    public function validate($model, $user = null)
    {
        //Get entity attributes

        $userDriver = config('asgard.user.config.driver');

        $entityNamespace = get_class($model);
        $entityNamespaceExploded = explode('\\', strtolower($entityNamespace));
        $moduleName = $entityNamespaceExploded[1]; //Get module name
        $entityName = $entityNamespaceExploded[3]; //Get entity name
        //Get current full date
        $now = Carbon::now()->format('Y-m-d h:i:s');
        $subscription = Subscription::whereHas('limits', function ($q) use ($entityNamespace) {
            //filter limits
            $q->where('entity', $entityNamespace);
        })->whereDate('end_date', '>', $now)->whereDate('start_date', '<=', $now)->where(function ($query) use ($userDriver, $user) {
            $query->whereNull('entity')->orWhere(function ($query) use ($userDriver, $user) {
                $query->where('entity_id', ($user ? $user->id : auth()->user()->id))->where('entity', "Modules\\User\\Entities\\{$userDriver}\\User");
            });
        })->where('status', 1)
            ->orderBy('id')
            ->first();
        if (! empty($subscription)) {
            $limitsDisabled = 0;
            $subLimits = $subscription->limits;
            foreach ($subLimits as $limit) {
                $validateLimit = true;
                $modelValue = null;
                //Validate if limit has attribute
                if ($validateLimit) {
                    if ((int) $limit->quantity > 0) {
                        if ((int) $limit->quantity_used >= (int) $limit->quantity) {
                            $limitsDisabled++;
                        }
                    }
                }
            }
            if ($limitsDisabled == count($subLimits)) {
                return false;
            }

            return $subscription;
        }

        return false;
    }

    /*
    * Get if user has active subscription
    */
    public function checkHasUserSuscription($data)
    {
        \Log::info('Iplan: Services|SubscriptionService|checkHasUserSuscription');

        //Get Last Active Subscription
        $oldSubscription = app("Modules\Iplan\Repositories\SubscriptionRepository")
            ->where('entity_id', '=', $data['entity_id'])
            ->where('entity', '=', $data['entity'])
            ->where('status', '=', 1)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! is_null($oldSubscription) && $oldSubscription->isAvailable) {
            return $oldSubscription;
        }

        return null;
    }

    /*
    * Add limits to old subscription when plan frenquency is Unique
    */
    public function addLimitsWhenIsUniqueFrequency($plan, $oldSubscription)
    {
        // All limits from new plan
        foreach ($plan->limits as $key => $planLimit) {
            // Get limit in old subscription
            $limitSubscription = $oldSubscription->limits->where('entity', '=', $planLimit->entity)->where('attribute', '=', $planLimit->attribute)->first();

            //Exist the plan limit in old subscription
            if (! is_null($limitSubscription)) {
                //Get new quantity
                //$newQuantity = $limitSubscription->quantityAvailable + $planLimit->quantity;
                $newQuantity = $limitSubscription->quantity + $planLimit->quantity;

                // Save new limit in old subscription
                $limitSubscription->quantity = $newQuantity;
                $limitSubscription->save();
            } else {
                //Not exist so create the new limit in old Subscription
                $limitData = [
                    'name' => $planLimit->name,
                    'entity' => $planLimit->entity,
                    'quantity' => $planLimit->quantity,
                    'quantity_used' => 0,
                    'attribute' => $planLimit->attribute,
                    'attribute_value' => $planLimit->attribute_value,
                    'subscription_id' => $oldSubscription->id,
                ];

                $oldSubscription->limits()->create($limitData);
            }
        }

        return $oldSubscription;
    }
}
