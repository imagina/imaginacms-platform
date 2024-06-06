<?php

namespace Modules\Notification\Events\Handlers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Notification\Entities\Notification;
use Modules\Notification\Entities\Rule;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationHandler implements ShouldQueue
{
  use InteractsWithQueue;
  
  private $module;
  private $ruleService;
  private $notification;
  private $providerRepository;
  private $entity;
  
  public function handle($event)
  {
   
    // each event handle must have a "notification" method with all the necessary data for the notification
    // for more details see the README.md file
    if (method_exists($event, "notification")) {
      
      $this->module = app('modules');
      $this->ruleService = app('Modules\\Notification\\Repositories\\RuleRepository');
      $this->notification = app('Modules\\Notification\\Services\\Inotification');
      $this->providerRepository = app('Modules\\Notification\\Repositories\\ProviderRepository');
      
      // getting the notifiable configs from enabled modules only
      $notifiable = $this->ruleService->moduleConfigs($this->module->allEnabled());
 
      // Getting the entity name from event entity
      $entityClassName = "";
  
      // each event handle must have a "entity" object class and it must match with the entity registered in the rule
      if (isset($event->entity) && is_object($event->entity)) {
        $entityClassName = get_class($event->entity);
        $this->entity = $event->entity;

      } else {
        \Log::info("[Notification Handler]::No valid data entity in: ".class_basename($event));
        return false;
        
      }
      
      // Reorganization notifiable by entityName
      $notifiable = collect($notifiable)->keyBy("entityName");
     
      // finding entity by name
      $entityConfig = $notifiable[$entityClassName];
    
      // Getting the class name of the event
      $eventClassName = get_class($event);
      
      // Ordering events by path
      $events = collect($entityConfig["events"])->keyBy("path");
    
      // if isset the event in notifiable entity, then evaluate conditions
      if (isset($events[$eventClassName])) {
        $notifiableConfigEvent = $events[$eventClassName];
        
        // Merge event notification data with event notifiable entity data
        $notificationData = array_merge($notifiableConfigEvent, $event->notification());
        
        //finding Rules in DB by event path
      
        //$rules = Rule::where("event_path", $eventClassName)->where("status",1)->get(); //the rule must be activated
        $rules = $this->ruleService->getItemsBy((object)["include" => [],"filter" => (object)["eventPath" => $eventClassName,"status" => 1]]);
  
        // evaluating each rule founded
        foreach ($rules as $rule) {
   
          // if all the rule conditions are met
          if ($this->conditionsPassed($rule->conditions, $entityConfig["conditions"])) {
            
            if($rule->settings) // settings stored for each provider
              foreach ($rule->settings as $providerKey => $setting) {
                if(isset($setting->status) && $setting->status){ //only the provider enabled for the rule
                
                  $provider = $this->providerRepository->getItem($providerKey, (object)["include" => [],"filter" => (object)["field" => "system_name"]]);
                
                  if($provider && $provider->status ) // only if the provider exist and it's enabled
                 
                      $this->sendNotification($setting, $notificationData, $provider);
                    
                }
              }
          } else {
            \Log::info("[Notification/Rule] the rule {$rule->name} for the event: {$eventClassName}, don't pass the conditions");
          }
        }
      }else{
        \Log::info("[Notification Handler] The event class path: ".$eventClassName." doesn't exist in notifiable events");
        return false;
      }
    }else{
      \Log::info("[Notification Handler] The event: ".class_basename($event)." doesn't have the require 'notification' method");
      return false;
    }
  }
  
  private function conditionsPassed($ruleConditions, $entityConditions)
  {
  
    foreach ($entityConditions as $key => $entityCondition) {
      
      if (isset($ruleConditions->{$entityCondition["name"]})) {
        $condition = $ruleConditions->{$entityCondition["name"]};
        
        //if condition is "any" continue the foreach
        if ($condition == "any")
          continue;
        
        //getting param value from event entity
        $param = $this->getEntityParam($entityCondition["name"]);
        
        if ($param != "paramNotFound") {
          
          //switch conditions type
          switch ($entityCondition["type"]) {
            case 'recursive':
              
              if (!$this->checkForRecursiveCondition($param, $condition))
                return false;
              break;
            
            case 'select':
              if (!($condition == $param))
                return false;
              break;
          }
          
        } else {
          return false;
        }
      }
    }
    
    return true;
  }
  
  private function getEntityParam($entityName)
  {
    $entityNameArray = explode(".", $entityName);
    
    $entityParam = $this->entity;
    
    foreach ($entityNameArray as $name) {
      if (isset($entityParam->{$name}) || $entityParam->{$name} == null) {
        $entityParam = $entityParam->{$name};
      } else {
        return "paramNotFound";
      }
    }
    
    return $entityParam;
  }
  
  private function checkForRecursiveCondition($param, $condition)
  {
    
    // switch recursive types
    switch ($condition->type) {
      case 'comparatorSimple':
        $operator = $condition->operator;
        //switch operator type
        switch ($operator) {
          case 'contains':
            if (!Str::contains($param, $condition->value))
              return false;
            break;
          case 'exactMatch':
            if (!$param == $condition->value)
              return false;
            break;
          case 'greaterThan':
            if (!($param > $condition->value))
              return false;
            break;
          case 'lessThan':
            if (!($param < $condition->value))
              return false;
            break;
          
        }
        break;
      
      // here for add another complex recursive type
    }
    
    
    return true;
  }
  
  
  private function sendNotification($setting, $notificationData, $provider){
    
  
    //sending to recipients from rule settings in DB
    foreach ($setting->recipients as $recipient) {
  
        // finding the recipient in the default entity
        if (isset($this->entity->{$recipient}))
          $recipient = $entity->{$recipient};
        
        $this->notification->to($recipient)->provider($provider)->push([
          "entity" => $this->entity,
          "data" => $notificationData
        ]);
      
    }
    
    //sending to recipients into notificationData in event recipients
    if(isset($notificationData["recipients"])){
      
      $types = $notificationData["recipients"];
      if(isset($types[$provider->type]) && $types[$provider->type]){
        $recipients = $types[$provider->type];
        if(!is_array($recipients)) $recipients = [$recipients];
          foreach ($recipients as $recipient){
            
              $this->notification->to($recipient)->provider($provider)->push([
                "entity" => $this->entity,
                "data" => $notificationData,
                "setting" => $setting
              ]);
            
          }
      }
    }
  }
 
}