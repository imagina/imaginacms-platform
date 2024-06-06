<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Notification\Entities\Provider;
use Modules\Notification\Http\Requests\CreateNotificationRequest;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Http\Requests\CreateProviderRequest;
use Modules\Notification\Http\Requests\CreateRuleRequest;
use Modules\Notification\Http\Requests\UpdateProviderRequest;
use Modules\Notification\Http\Requests\UpdateRuleRequest;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Repositories\ProviderRepository;
use Modules\Notification\Repositories\RuleRepository;
use Modules\Notification\Transformers\NotificationTransformer;
use Modules\Notification\Services\Notification as PushNotification;
use Modules\Notification\Transformers\ProviderTransformer;
use Modules\Notification\Transformers\RuleTransformer;

class RuleApiController extends BaseApiController
{
  /**
   * @var NotificationRepository
   */
  private $service;
  private $module;
  
  public function __construct(RuleRepository $service)
  {
    $this->service = $service;
    $this->module = app('modules');
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
      
      $data = RuleTransformer::collection($dataEntity);
      
      //Response
      $response = ["data" => $data];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function indexConfig(Request $request)
  {
    try {
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
  
      //Response
      $response = ["data" => $this->service->moduleConfigs($this->module->allEnabled())];
      
      //If request pagination add meta-page
    // $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
      if (!$dataEntity) throw new \Exception('Item not found', 204);
      
      //Response
      $response = ["data" => new RuleTransformer($dataEntity)];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
      $this->validateRequestApi(new CreateRuleRequest((array)$data));
      
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
      $this->validateRequestApi(new UpdateRuleRequest((array)$data));
      
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
