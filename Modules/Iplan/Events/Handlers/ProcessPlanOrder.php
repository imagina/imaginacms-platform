<?php

namespace Modules\Iplan\Events\Handlers;

use Illuminate\Http\Request;

class ProcessPlanOrder
{
    private $logtitle;

    private $planRepository;

    public function __construct()
    {
        $this->logtitle = '[IPLAN-SUBSCRIPTION]::';
        $this->planRepository = app("Modules\Iplan\Repositories\PlanRepository");
    }

    public function handle($event)
    {
        $order = $event->order;
        //Order is Proccesed
        if ($order->status_id == 13) {
            foreach ($order->orderItems as $item) {
                switch ($item->entity_type) {
                    case 'Modules\Iplan\Entities\Plan':
                        $userDriver = config('asgard.user.config.driver');
                        //Get plan Id form setting
                        $planIdInOrderItem = $item->entity_id;
                        //Get user registered data
                        $user = $order->customer;

                        $plan = $this->planRepository->getItem($planIdInOrderItem);

                        //Create subscription
                        if ($planIdInOrderItem && $user) {
                            //Init subscription controller
                            $subscriptionController = app('Modules\Iplan\Http\Controllers\Api\SubscriptionController');
                            //Create subscription
                            request()->session()->put('subscriptedUser.id', $user->id);
                            $subscriptionController->create(new Request([
                                'attributes' => [
                                    'entity' => "Modules\\User\\Entities\\{$userDriver}\\User",
                                    'entity_id' => $user->id,
                                    'plan_id' => $planIdInOrderItem,
                                    'options' => $item->options,
                                ],
                            ]));
                            //Log
                            \Log::info("{$this->logtitle}Order Completed | Register subscription, Plan: {$plan->id} - {$plan->name} to user ID {$user->id}");
                        }
                        break;
                }
            }
        }// end If
    }// If handle
}
