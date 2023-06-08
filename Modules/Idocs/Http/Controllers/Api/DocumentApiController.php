<?php

namespace Modules\Idocs\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Idocs\Http\Requests\CreateDocumentRequest;
use Modules\Idocs\Repositories\DocumentRepository;
use Modules\Idocs\Transformers\DocumentTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class DocumentApiController extends BaseApiController
{
  private $document;

  public function __construct(DocumentRepository $document)
  {
    parent::__construct();
    $this->document = $document;
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
      $documents = $this->document->getItemsBy($params);

      //Response
      $response = ["data" => DocumentTransformer::collection($documents)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($documents)] : false;
    } catch (\Exception $e) {
      Log::Error($e);
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
      $document = $this->document->getItem($criteria, $params);

      //Break if no found item
      if (!$document) throw new Exception('Item not found', 404);

      //Response
      $response = ["data" => new DocumentTransformer($document)];

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
      $data = $request->input('attributes') ?? [];//Get data
  
      //Validate Request
      $this->validateRequestApi(new CreateDocumentRequest($data));
      
      //Create item
      $document = $this->document->create($data);

      //Response
      $response = ["data" => new DocumentTransformer($document)];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      Log::Error($e);
      \DB::rollback();//Rollback to Data Base
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

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      //Request to Repository
      $document = $this->document->getItem($criteria, $params);
      //Request to Repository
      $this->document->update($document, $data);
      //Response
      $response = ["data" => trans('iblog::common.messages.resource updated')];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      Log::Error($e);
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
      $document = $this->document->getItem($criteria, $params);

      //call Method delete
      $this->document->destroy($document);

      //Response
      $response = ["data" => trans('iblog::common.messages.resource deleted')];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      Log::Error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }
}
