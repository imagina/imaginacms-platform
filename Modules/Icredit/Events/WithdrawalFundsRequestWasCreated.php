<?php

namespace Modules\Icredit\Events;

use Modules\User\Entities\Sentinel\User;
use Modules\Requestable\Entities\Requestable;

class WithdrawalFundsRequestWasCreated
{
  public $requestable;
  public $notificationService;
  
  public function __construct($requestable)
  {
    
    //\Log::info('Icredit: Events|WithdrawalFundsRequestWasCreated|Requestable: '.json_encode($requestable));
    $this->requestable = $requestable;
    $this->notificationService = app("Modules\Notification\Services\Inotification");
    $this->notification();
  }
  
  
  public function notification()
  {
    
    \Log::info('Icredit: Events|WithdrawalFundsRequestWasCreated|Notification');
    
    $emailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
    $usersToNotity = json_decode(setting("icommerce::usersToNotify", null, "[]"));
    
    if (empty($emailTo))
      $emailTo = explode(',', setting('icommerce::form-emails'));
    
    $users = User::whereIn("id", $usersToNotity)->get();
    $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
    
    // PD: Relation from trait IsFillable
    $fields = $this->requestable->fields()->get();
    $amount = $fields->where("name", "amount")->first()->value;
    
    //\Log::info('Icredit: Events|WithdrawalFundsRequestWasCreated|Notification|Amount: '.$amount);
    
    $this->notificationService->to([
      "email" => $emailTo,
      "broadcast" => $users->pluck('id')->toArray(),
      "push" => $users->pluck('id')->toArray(),
    ])->push(
      [
        "title" => trans("icredit::credits.title.WithdrawalFundsRequestWasCreated"),
        "message" => trans("icredit::credits.messages.WithdrawalFundsRequestWasCreated", ["requestUserName" => $this->requestable->createdByUser->present()->fullname, "requestAmount" => $amount, "requestableId" => $this->requestable->id]),
        "icon_class" => "fa fa-bell",
        "withButton" => true,
        "link" => url('/iadmin/#/requestable/index/?edit=' . $this->requestable->id),
        "setting" => [
          "saveInDatabase" => true
        ],
      
      ]
    );
  }
}

