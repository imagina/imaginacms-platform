<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Notification\Http\Requests\CreateNotificationRequest;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Transformers\NotificationTransformer;
use Modules\Notification\Services\Notification as PushNotification;
class NotificationsController extends BaseApiController
{
  /**
   * @var NotificationRepository
   */
  private $notification;
  private $notificationP;
  
  public function __construct(NotificationRepository $notification, PushNotification $notificationP)
  {
    $this->notification = $notification;
    $this->notificationP= $notificationP;
  }
  
  public function markAsRead(Request $request)
  {
    $updated = $this->notification->markNotificationAsRead($request->get('id'));
    
    return response()->json(compact('updated'));
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
      $dataEntity = $this->notification->getItemsBy($params);
      //Response
      $response = ["data" => NotificationTransformer::collection($dataEntity)];
      
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
      $dataEntity = $this->notification->getItem($criteria, $params);
      
      //Break if no found item
      if (!$dataEntity) throw new Exception('Item not found', 204);
      
      //Response
      $response = ["data" => new NotificationTransformer($dataEntity)];
      
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
    try {
      $data = (object)$request->input('attributes') ?? [];//Get data
      
      if(isset($data->user_id)){
        $this->notificationP->to($data->user_id)->push($data->title, $data->caption??'',$data->entity??'', $data->link);
      }else{
        $this->notificationP->push($data->title, $data->caption??'',$data->entity??'', $data->link);
      }
      
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
      $data = $request->input('attributes') ?? [];//Get data
      
      //Validate Request
      $this->validateRequestApi(new CreateNotificationRequest($data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $dataEntity = $this->notification->getItem($criteria, $params);
      //Request to Repository
      $this->notification->update($dataEntity, $data);
      
      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
      
      //Request to Repository
      $dataEntity = $this->notification->getItem($criteria, $params);
      
      //call Method delete
      $this->notification->delete($dataEntity);
      
      //Response
      $response = ["data" => "Item deleted"];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  public  function updateAll(Request $request){
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      $data = $request->input('attributes') ?? [];//Get data
      //Request to Repository
      $dataEntity = $this->notification->getItemsBy($params);
      $crterians=$dataEntity->pluck('id');
      $dataEntity=$this->notification->updateItems($crterians, $data);
      //Response
      $response = ["data" => NotificationTransformer::collection($dataEntity)];
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
  
  public  function deleteAll(Request $request){
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $dataEntity = $this->notification->getItemsBy($params);
      $crterians=$dataEntity->pluck('id');
      $this->notification->deleteItems($crterians);
      //Response
      $response = ["data" => "Items deleted"];
      
    } catch (\Exception $e) {
      \Log::error($e);
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  
}