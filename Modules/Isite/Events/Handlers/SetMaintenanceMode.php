<?php

namespace Modules\Isite\Events\Handlers;

use Modules\Isite\Entities\Organization;

use Modules\Isite\Repositories\OrganizationRepository;
use Modules\Isite\Events\OrganizationWasCreated;

class SetMaintenanceMode
{
  

  public function handle($event)
  {
    try {
      
      // All params Event
      $params = $event->params;
      // Extra data custom event entity
      //$extraData = $params['extraData'];

      $model = $params['model'];

      \Log::info('Isite: Events|Handlers|SetMaintenanceMode|Organization:'.$model->id);

      if($model->enable==0){
        $model->putDownForMaintenance();
        \Log::info('Isite: Events|Handlers|SetMaintenanceMode| SET MAINTENANCE: ON');
      }else{
        $model->update(['maintenance_mode' => null]);
        \Log::info('Isite: Events|Handlers|SetMaintenanceMode| SET MAINTENANCE: OFF');
      }
      
      
    } catch (\Exception $e) {
      \Log::info($e->getMessage().' '.$e->getFile().' '.$e->getLine());
    }
    
  }
  
  
}
