<?php

namespace Modules\Core\Icrud\Controllers;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

//Default transformer
use Modules\Core\Icrud\Transformers\CrudResource;

class BaseCrudController extends BaseApiController
{
  /**
   * Controller to create model
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get model data
      $modelData = $request->input('attributes') ?? [];

      //Validate Request
      if (isset($this->model->requestValidation['create'])) {
        $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
      }

      //Create model
      $model = $this->modelRepository->create($modelData);

      //Response
      $response = ["data" => CrudResource::transformData($model)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Controller To request all model data
   *
   * @return mixed
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from request
      $params = $this->getParamsRequest($request);

      //Request data to Repository
      $models = $this->modelRepository->getItemsBy($params);

      //Response
      $response = ["data" => CrudResource::transformData($models)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($models)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Controller to request model by criteria
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from request
      $params = $this->getParamsRequest($request);

      //Request data to Repository
      $model = $this->modelRepository->getItem($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Response
      $response = ["data" => CrudResource::transformData($model)];
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Controller to update model by criteria
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get model data
      $modelData = $request->input('attributes') ?? [];
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
  
      //auto-insert the criteria in the data to update
      isset($params->filter->field) ? $field = $params->filter->field : $field = "id";
      $data[$field] = $criteria;
      
      //Validate Request
      if (isset($this->model->requestValidation['update'])) {
        $this->validateRequestApi(new $this->model->requestValidation['update']($modelData));
      }

      //Update model
      $model = $this->modelRepository->updateBy($criteria, $modelData, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Response
      $response = ["data" => CrudResource::transformData($model)];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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

      //Delete methomodel
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
   * Controller to delete model by criteria
   *
   * @param $criteria
   * @return mixed
   */
  public function restore($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //Delete methomodel
      $model = $this->modelRepository->restoreBy($criteria, $params);

      //Throw exception if no found item
      if (!$model) throw new Exception('Item not found', 204);

      //Response
      $response = ["data" => CrudResource::transformData($model)];
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
   * Controller to do a bulk order of a model
   * @param Request $request
   * @return mixed
   */
  public function bulkOrder(Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get model data
      $data = $request->input('attributes') ?? [];
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Update model
      $bulkOrderResult = $this->modelRepository->bulkOrder($data, $params);

      //Response
      $response = ["data" => CrudResource::transformData($bulkOrderResult)];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Controller to request all model data from a static entity
   *
   * @param $entityClass
   * @return mixed
   */
  public function indexStatic(Request $request, $params)
  {
    try {
      //Instance model
      $model = app($params['entityClass']);

      //Request data
      $method = $params['method'] ?? 'index';
      $models = $model->$method();

      //Response
      $response = ["data" => $models];
    } catch (\Exception $e) {
      \Log::Error($e);
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Controller to request all model data from a static entity
   *
   * @param $entityClass
   * @return mixed
   */
  public function showStatic($criteria, Request $request, $params)
  {
    try {
      //Instance model
      $model = app($params['entityClass']);

      //Request data
      $method = $params['method'] ?? 'show';
      $item = $model->$method($criteria);

      //Response
      $response = ["data" => $item];
    } catch (\Exception $e) {
      \Log::Error($e);
      $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
