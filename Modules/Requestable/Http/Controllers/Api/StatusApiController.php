<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Requestable\Entities\Status;
use Modules\Requestable\Repositories\StatusRepository;

use Modules\Requestable\Services\StatusService;

use Illuminate\Http\Request;

class StatusApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;
  private $statusService;

  public function __construct(
    Status $model, 
    StatusRepository $modelRepository,
    StatusService $statusService
  ){
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    $this->statusService = $statusService;
  }



  /**
   * Controller to delete model by criteria
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //Check status to delete
      $this->statusService->checkIfStatusIsDefault($criteria,$params);

      //Delete status
      $this->modelRepository->deleteBy($criteria, $params);

      //Response
      $response = ["data" => "Item deleted"];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
  * Update order (Position Request)
  * @param $request
  */
  public function updateOrderStatus(Request $request)
  {
    \DB::beginTransaction();
    try {

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Get data
      $data = $request->input('attributes');

      //Service
      $this->statusService->updateOrderPosition($data['category'],$params);
      
      //Response
      $response = ["data" => "Order Updated"];
      
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }

}
