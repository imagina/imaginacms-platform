<?php

namespace Modules\Iplan\Events\Handlers;

use Modules\Iplan\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;

class RegisterNewSubscription
{
  
  private $logtitle;
  private $notification;
  private $planRepository;
  
  public function __construct()
  {
    $this->logtitle = '[IPLAN-SUBSCRIPTION]::';
    $this->notification = app("Modules\Notification\Services\Inotification");
    $this->planRepository = app("Modules\Iplan\Repositories\PlanRepository");
  }
  
  public function handle($event)
  {
    //Get plan Id form setting
    $planIdToRegisteredUsers = setting('iplan::defaultPlanToNewUsers');
    //Get user registered data
    $user = $event->user;
    
    $userDriver = config('asgard.user.config.driver');
    
    $plan = $this->planRepository->getItem($planIdToRegisteredUsers);
    
    //Create subscription
    if ($planIdToRegisteredUsers && $user) {
      //Init subscription controller
      $subscriptionController = app('Modules\Iplan\Http\Controllers\Api\SubscriptionController');
      //Create subscription
      $subscriptionController->create(new Request([
        'attributes' => [
          'entity' => "Modules\\User\\Entities\\{$userDriver}\\User",
          'entity_id' => $user->id,
          'plan_id' => $planIdToRegisteredUsers
        ]
      ]));
      //Log
      \Log::info("{$this->logtitle}New User | Register subscription, Plan: {$plan->id} - {$plan->name} to user ID {$user->id}");
      
    }
  }
}
