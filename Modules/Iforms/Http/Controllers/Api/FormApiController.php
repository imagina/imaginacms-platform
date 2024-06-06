<?php

namespace Modules\Iforms\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iforms\Http\Requests\CreateFormRequest;
use Modules\Iforms\Http\Requests\UpdateFormRequest as UpdateRequest;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Iforms\Transformers\FormTransformer;

// Repositories
use Modules\Iforms\Repositories\FormRepository;

class FormApiController extends BaseApiController
{
  private $resource;

  public function __construct(FormRepository $resource)
  {
    $this->resource = $resource;
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
      $data = $this->resource->getItemsBy($params);
      //Response
      $response = ["data" => FormTransformer::collection($data)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($data)] : false;
    } catch (\Exception $e) {
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
      $data = $this->resource->getItem($criteria, $params);
      //Break if no found item
      if (!$data) throw new \Exception('Item not found', 204);
      //Response
      $response = ["data" => new FormTransformer($data)];
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($data)] : false;
    } catch (\Exception $e) {
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
      $data = $request->input('attributes') ?? [];//Get data
      //Validate Request
      $this->validateRequestApi(new CreateFormRequest($data));
      //Create item
      $newData = $this->resource->create($data);
      //Response
      $response = ["data" => new FormTransformer($newData)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($criteria, Request $request)
  {

    \DB::beginTransaction();
    try {
      $params = $this->getParamsRequest($request);

      $data = $request->input('attributes');
      //Validate Request
      $this->validateRequestApi(new UpdateRequest($data));
      //Update data
      $entity = $this->resource->getItem($criteria, $params);
      $newData = $this->resource->update($entity, $data);
      //Response
      $response = ['data' => $newData];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);
      //Delete data
      $entity = $this->resource->getItem($criteria, $params);
      $this->resource->destroy($entity);
      //Response
      $response = ['data' => ''];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, $status ?? 200);
  }

}
