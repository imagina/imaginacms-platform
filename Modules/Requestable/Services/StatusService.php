<?php


namespace Modules\Requestable\Services;

use Modules\Requestable\Repositories\StatusRepository;


class StatusService
{
 
  private $statusRepository;
  
  public function __construct(
    StatusRepository $statusRepository
  ){
   
    $this->statusRepository = $statusRepository;
  }
  
  /**
   * Check if status to delete is Default
   * @param $criteria(id to search)
  */
  public function checkIfStatusIsDefault($criteria,$params){

    $model = $this->statusRepository->getItem($criteria, $params);

    //Throw exception if no found item
    if (!$model) throw new \Exception('Item not found', 204);

    //The status is default
    if($model->default){

      //Buscar el status hermano mas antiguo creado y que no sea final
      $params = [
        'filter'=>['category_id' => $model->category_id,'final' => 0,'default' => 0],
        'order' => ['way' => 'asc'],
        'take'=> 1
      ];
      $statuses = $this->statusRepository->getItemsBy(json_decode(json_encode($params)));

      if(!is_null($statuses)){

        //\Log::info("Requestable - Service|StatusService|checkIfStatusIsDefault|status id ".$statuses[0]->id);

        // New status like default for this category
        $statuses[0]->default = 1;
        $statuses[0]->save();

      }

    }

  }


  /**
  * Update order position to Requests
  * @param $data (array)
  * @param $params (from Request)
  */
  public function updateOrderPosition($data,$params){


    foreach ($data as $position => $item) {

      $status = $this->statusRepository->getItem($item['id'],json_decode(json_encode($params)));

      if(!is_null($status))
        $this->statusRepository->update($status, ['position' => $position]);

      
    }
  }
  
}
