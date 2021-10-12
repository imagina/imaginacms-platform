<?php

namespace Modules\Notification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Notification\Http\Requests\CreateNotificationRequest;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Notification\Transformers\NotificationTransformer;
use Modules\Notification\Services\Inotification as PushNotification;

class NotificationApiController extends BaseApiController
{
  /**
   * @var NotificationRepository
   */
  private $notification;
  private $notificationP;
  
  public function __construct(NotificationRepository $notification, PushNotification $notificationP)
  {
    $this->notification = $notification;
    $this->notificationP = $notificationP;
  }
  
  public function markAsRead(Request $request, $id)
  {
    
    $updated = $this->notification->markNotificationAsRead($id);
  
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
      \Log::error($e->getMessage());
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
      if (!$dataEntity) throw new Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new NotificationTransformer($dataEntity)];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
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
  
      //Validate Request
      $this->validateRequestApi(new CreateNotificationRequest((array)$data));
 
      
      $this->notificationP->type($data->type)->to($data->to)
        ->push(
          [
            "title" => $data->title,
            "message" => $data->message,
            "setting" => json_decode(json_encode($data->setting)),
            "icon_class" => $data->icon_class,
            "link" => $data->link ?? url('')
          ]
        );
      
      $response = ["data" => 'Item Created'];
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
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
      \Log::error($e->getMessage());
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
      $this->notification->destroy($dataEntity);
      
      //Response
      $response = ["data" => "Item deleted"];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  public function updateItems(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      $data = $request->input('attributes') ?? [];//Get data
      //Request to Repository
      $dataEntity = $this->notification->getItemsBy($params);
      $crterians = $dataEntity->pluck('id');
      $dataEntity = $this->notification->updateItems($crterians, $data);
      //Response
      $response = ["data" => NotificationTransformer::collection($dataEntity)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  public function deleteItems(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $dataEntity = $this->notification->getItemsBy($params);
      $crterians = $dataEntity->pluck('id');
      $this->notification->deleteItems($crterians);
      //Response
      $response = ["data" => "Items deleted"];
      
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
  
  
}
