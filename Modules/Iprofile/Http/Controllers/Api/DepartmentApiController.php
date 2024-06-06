<?php

namespace Modules\Iprofile\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iprofile\Http\Requests\CreateDepartmentRequest;
use Modules\Iprofile\Http\Requests\UpdateDepartmentRequest;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Repositories\DepartmentRepository;

class DepartmentApiController extends BaseApiController
{
  private $department;
  private $setting;

  public function __construct(
    DepartmentRepository $department,
    SettingApiController $setting)
  {
    $this->department = $department;
    $this->setting = $setting;
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
      $departments = $this->department->getItemsBy($params);

      //Response
      $response = [
        "data" => DepartmentTransformer::collection($departments)
      ];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($departments)] : false;
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
      $department = $this->department->getItem($criteria, $params);

      //Break if no found item
      if (!$department) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new DepartmentTransformer($department)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($department)] : false;
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
      //Validate Permission
      $this->validatePermission($request,'profile.departments.create');

      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new CreateDepartmentRequest($data));

      //Create item
      $department = $this->department->create($data);

      //Create Settings
      if (isset($data["settings"]))
        foreach ($data["settings"] as $setting) {
          if (isset($setting["value"]) && !empty($setting["value"])) {
            $setting['related_id'] = $department->id;// Add department Id
            $setting['entity_name'] = 'department';// Add entity name
            $this->validateResponseApi(
              $this->setting->create(new Request(['attributes' => (array)$setting]))
            );
          }
        }

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
      //Validate Permission
      $this->validatePermission($request,'profile.departments.edit');

      //Get data
      $data = $request->input('attributes');

      //Validate Request
      $this->validateRequestApi(new UpdateDepartmentRequest($data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $department = $this->department->updateBy($criteria, $data, $params);

      //Create or Update Settings
      if (isset($data["settings"]))
        foreach ($data["settings"] as $setting) {
          if (isset($setting["value"]) && !empty($setting["value"])) {
            if (!isset($setting['id'])) {
              $setting['related_id'] = $department->id;// Add department Id
              $setting['entity_name'] = 'department';// Add entity name
              $this->validateResponseApi(
                $this->setting->create(new Request(['attributes' => (array)$setting]))
              );
            } else
              $this->validateResponseApi(
                $this->setting->update($setting['id'], new Request(['attributes' => (array)$setting]))
              );
          } else {
            if (isset($setting['id'])) {
              $this->validateResponseApi(
                $this->setting->delete($setting['id'], new Request(['attributes' => (array)$setting]))
              );
            }
          }
        }

      //Response
      $response = ["data" => ''];
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
      //Validate Permission
      $this->validatePermission($request,'profile.departments.destroy');

      //Get params
      $params = $this->getParamsRequest($request);

      //call Method delete
      $this->department->deleteBy($criteria, $params);

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
