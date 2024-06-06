<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Notification\Entities\Provider;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Http\Requests\CreateTemplateRequest;
use Modules\Notification\Http\Requests\UpdateTemplateRequest;
use Modules\Notification\Repositories\TemplateRepository;
use Modules\Notification\Transformers\TemplateTransformer;

class TemplateApiController extends BaseApiController
{
  /**
   * @var NotificationRepository
   */
  private $service;
  
  public function __construct(TemplateRepository $service)
  {
    $this->service = $service;
  }
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $dataEntity = $this->service->getItemsBy($params);
      
      //Response
      $response = [
        "data" => TemplateTransformer::collection($dataEntity)
      ];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $dataEntity = $this->service->getItem($criteria, $params);
      
      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new TemplateTransformer($dataEntity)];
      
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get data
      $data = $request->input('attributes');
      
      //Validate Request
      $this->validateRequestApi(new CreateTemplateRequest((array)$data));
      
      //Create item
      $this->service->create($data);
      
      //Response
      $response = ["data" => ""];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  
  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get data
      $data = $request->input('attributes');
      
      //Validate Request
      $this->validateRequestApi(new UpdateTemplateRequest((array)$data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $this->service->updateBy($criteria, $data, $params);
      
      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  
  /**
   * DELETE A ITEM
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
      
      //call Method delete
      $this->service->deleteBy($criteria, $params);
      
      //Response
      $response = ["data" => ""];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  
}
