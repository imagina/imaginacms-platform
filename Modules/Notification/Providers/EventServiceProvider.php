<?php

namespace Modules\Notification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Notification\Events\Handlers\NotificationHandler;
use Modules\Notification\Repositories\RuleRepository;
use Illuminate\Support\Arr;

class EventServiceProvider extends ServiceProvider
{
  private $module;
  private $service;
  protected $listen;
  
 
  
  public function register()
  {
    $this->module = app('modules');
    
    if(isset($this->module) && $this->module && $this->module->allEnabled()){
      $this->service = app('Modules\\Notification\\Repositories\\RuleRepository');
      $notifiable = $this->service->moduleConfigs($this->module->allEnabled());
      //dd($notifiable);
      $this->listen  = [];
  
      foreach ($notifiable as $entity){
        foreach ($entity["events"] as $event) {
      
          $listen = [$event["path"] => [
            NotificationHandler::class
          ]];
      
          array_push(
            $this->listen,
            $listen
          );
        }
      }
      $this->listen = Arr::collapse($this->listen);
    }
    
  }
  
 
}
