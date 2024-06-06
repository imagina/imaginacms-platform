<?php

namespace Modules\Ilocations\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Ilocations\Http\Requests\CreateProvinceRequest;
use Modules\Ilocations\Http\Requests\UpdateProvinceRequest;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Ilocations\Transformers\ProvinceTransformer;

class ProvinceApiController extends BaseApiController
{
    /**
     * @var Application
     */
    private $province;

    public function __construct(
        ProvinceRepository $province)
    {

        $this->province = $province;

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
            $dataEntity = $this->province->getItemsBy($params);

            //Response
            $response = ["data" => ProvinceTransformer::collection($dataEntity)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $dataEntity = $this->province->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new Exception('Item not found', 404);

      //Response
      $response = ["data" => new ProvinceTransformer($dataEntity)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];
            $this->validateRequestApi(new CreateProvinceRequest($data));
            $province = $this->province->create($data);
            $response = ['data' => new ProvinceTransformer($province)];
            $status = 200;
            DB::commit();
        } catch (Exception $exception) {
            Log::Error($exception);
            DB::rollback();
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status);
    }

    public function update($criteria, Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];
            $this->validateRequestApi(new UpdateProvinceRequest($data));
            $params = $this->getParamsRequest($request);
            $province = $this->province->getItem($criteria, $params);
            $this->province->update($province, $data);
            $response = ['data' => new ProvinceTransformer($province)];
            $status = 200;
            DB::commit();
        } catch (Exception $exception) {
            Log::Error($exception);
            DB::rollback();
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status);
    }

    public function delete($criteria, Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $province = $this->province->getItem($criteria, $params);
            $this->province->destroy($province);
            $response = ['data' => true];
            $status = 200;
            DB::commit();
        } catch (Exception $exception) {
            Log::Error($exception);
            DB::rollback();
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status);
    }
}
