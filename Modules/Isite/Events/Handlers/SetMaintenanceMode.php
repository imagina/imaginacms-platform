<?php

namespace Modules\Isite\Events\Handlers;

use Modules\Isite\Entities\Organization;

use Modules\Isite\Repositories\OrganizationRepository;
//use Modules\Isite\Events\OrganizationWasCreated;

class SetMaintenanceMode
{
  
  private $log = "Isite: Events|Handler|SendMaintenanceMode|";
  public $notificationService;

  public function __construct()
  {
    $this->notificationService = app("Modules\Notification\Services\Inotification");
  }

    public function handle($event)
    {
        try {

      $isCreated = false;

      //When create
      if(isset($event->organization)){
        $model = $event->organization;
        $isCreated = true;
      }else{
        //when update
            $params = $event->params;
            // Extra data custom event entity
            //$extraData = $params['extraData'];

            $model = $params['model'];
      }


            \Log::info('Isite: Events|Handlers|SetMaintenanceMode|Organization:'.$model->id);

            if ($model->enable == 0) {
                $model->putDownForMaintenance();
                \Log::info('Isite: Events|Handlers|SetMaintenanceMode| SET MAINTENANCE: ON');
            } else {
                $model->update(['maintenance_mode' => null]);
                \Log::info('Isite: Events|Handlers|SetMaintenanceMode| SET MAINTENANCE: OFF');
            }

      $this->sendEmail($model,$isCreated);
      
      
        } catch (\Exception $e) {
            \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
        }
    
  }

  public function sendEmail($model, $isCreated)
  {

    \Log::info($this->log."sendEmail");

    if($model->wasChanged("status") || $isCreated){

      $user = $model->users->first();

      $emailsTo[] = $user->email;
      $title = trans("isite::organizations.title.organization updated");
      $message = trans("isite::organizations.messages.organization updated",[
        'status' => $model->statusName,
        'url' => $model->url,
        'admin' => url('/iadmin')
      ]);
      
      $this->notificationService->to([
          "email" => $emailsTo
        ])->push([
            "title" => $title,
            "message" => $message,
            "fromAddress" => env('MAIL_FROM_ADDRESS'),
            "fromName" => "",
            "setting" => [
                "saveInDatabase" => 0
            ]
      ]);
    
    }
}


}
