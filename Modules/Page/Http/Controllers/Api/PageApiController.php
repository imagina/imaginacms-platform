<?php

namespace Modules\Page\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Page\Entities\Page;
use Modules\Page\Http\Requests\CreatePageRequest;
use Modules\Page\Http\Requests\UpdatePageRequest;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Transformers\FullPageTransformer;
use Modules\Page\Transformers\PageApiTransformer;
use Modules\Page\Transformers\PageTransformer;

class PageApiController extends BaseApiController
{
  /**
   * @var PageRepository
   */
  private $repoEntity;

  public function __construct(PageRepository $page)
  {
    $this->repoEntity = $page;
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
      $dataEntity = $this->repoEntity->getItemsBy($params);

      //Response
      $response = [
        "data" => PageApiTransformer::collection($dataEntity)
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
  public function indexCMS(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Add filters
      $params->filter = (object)array_merge((array)$params->filter, [
        "type" => "cms",
        "allTranslations" => true
      ]);

      //Add the Request All Pages param to request
      $params->allowIndexAll = true;

      //Request to Repository
      $dataEntity = $this->repoEntity->getItemsBy($params);

      //Response
      $response = [
        "data" => PageApiTransformer::collection($dataEntity)
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
      $dataEntity = $this->repoEntity->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new PageApiTransformer($dataEntity)];

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
      $this->validateRequestApi(new CreatePageRequest((array)$data));

      //Create item
      $this->repoEntity->create($data);

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
      $this->validateRequestApi(new UpdatePageRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $this->repoEntity->updateBy($criteria, $data, $params);

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
      $this->repoEntity->deleteBy($criteria, $params);

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
