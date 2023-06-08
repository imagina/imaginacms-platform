<?php

namespace Modules\Icheckin\Http\Controllers\Api;

use App\Jobs\ExportReports\SpreedSheetNativeJob;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Icheckin\Http\Requests\CreateApprovalRequest;
use Modules\Icheckin\Http\Requests\CreateShiftRequest;
use Modules\Icheckin\Http\Requests\UpdateApprovalRequest;
use Modules\Icheckin\Http\Requests\UpdateShiftRequest;
use Modules\Icheckin\Repositories\ApprovalRepository;
use Modules\Icheckin\Repositories\ShiftRepository;
use Modules\Icheckin\Transformers\ApprovalTransformer;
use Modules\Icheckin\Transformers\ByShiftsTransformer;
use Modules\Icheckin\Transformers\ShiftTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;


class ApprovalApiController extends BaseApiController
{
  /**
   * Display a listing of the resource.
   * @return Response
   */
  private $service;
  
  public function __construct(ApprovalRepository $service)
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
        "data" => ApprovalTransformer::collection($dataEntity)
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
   * GET ITEMS
   *
   * @return mixed
   */
  public function byShifts(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      $params->filter->usersByDepartment = $this->getUsersByDepartment($params,'id',true);
      
      //Request to Repository
      $dataEntity = $this->service->getItemsWithShifts($params);
      
      
      
      //If request pagination add meta-page
      //$params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
      
      $filter = $params->filter;
      
      if(isset($filter->date) && (!isset($filter->repId) || !$filter->repId)){
        $date = $filter->date;
        $from = date("Y/m/d", strtotime($date->from));
        $to = date("Y/m/d", strtotime($date->to));
        if($from != $to){
          $dataEntity = $this->service->groupByUser($dataEntity);
        }
      }
      
      //Response
      $response = [
        "data" => ByShiftsTransformer::collection($dataEntity)
      ];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
  
  /**
   * GET ITEMS
   *
   * @return mixed
   */
  public function byShiftsReport(Request $request)
  {
  
   // try {
      $params = $this->getParamsRequest($request);//Get params from URL
      $reportName = 'timeSheetsReport-' . date('mdY') . '.xlsx';
      $params->reportName = 'timeSheetsReport';
    $params->filter->usersByDepartment = $this->getUsersByDepartment($params,'id',true);
      //$this->service->getReportToExport($params);
      // delete old reports
      deleteOldReportFiles('/storage/app/reports/user-'.$params->user->id.'/','timeSheetsReport');
    
      //Dispatch Job to do report file
      SpreedSheetNativeJob::dispatch($this->service, $reportName, $params)->onQueue('reports');
    
      //Response
      $response = ["data" => 'Report:: Creating timeSheets Report excel file...'];
  /*  } catch (\Exception $e) {
      $status = 500;
      $response = ["error" => $e->getMessage()];
    }*/
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
      //if (!$dataEntity) throw new \Exception('Item not found', 404);
      
      //Response
      $response = ["data" => $dataEntity ? new ApprovalTransformer($dataEntity) :""];
      
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
     
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
     
      //Get data
      $data = $request->input('attributes');
  
      //Validate Request
      $this->validateRequestApi(new CreateApprovalRequest((array)$data));
      
    
      //Create item
      $approval = $this->service->create($data);
  
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
      $this->validateRequestApi(new UpdateApprovalRequest((array)$data));
      
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
