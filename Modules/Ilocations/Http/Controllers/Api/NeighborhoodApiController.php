<?php


namespace Modules\Ilocations\Http\Controllers\Api;

// Libs
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use Log;
use DB;

// Custom Requests
use Modules\Ilocations\Http\Requests\CreateNeighborhoodRequest;
use Modules\Ilocations\Http\Requests\UpdateNeighborhoodRequest;

// Transformers
use Modules\Ilocations\Transformers\NeighborhoodTransformer;

// Repositories
use Modules\Ilocations\Repositories\NeighborhoodRepository;

class NeighborhoodApiController extends BaseApiController
{

    private $dataEntity;

    public function __construct(NeighborhoodRepository $dataEntity)
    {
        $this->neighborhood = $dataEntity;
    }

    public function index(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            $neighborhoods = $this->neighborhood->getItemsBy($params);

            $response = ['data' => NeighborhoodTransformer::collection($neighborhoods)];

            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($neighborhoods)] : false;

        } catch (Exception $exception) {
            Log::Error($exception);
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response,  $status ?? 200);
    }

    public function show($criteria, Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->neighborhood->getItem($criteria, $params);

            if (!$dataEntity) throw new Exception('Item not found', 404);

            $response = ['data' => new NeighborhoodTransformer($dataEntity)];

        } catch (Exception $exception) {

            Log::Error($exception);

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response,  $status ?? 200);
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new CreateNeighborhoodRequest($data));

            $dataEntity = $this->neighborhood->create($data);

            $response = ["data" => "Request successful"];

            DB::commit();
        } catch (Exception $exception) {

            Log::Error($exception);
            DB::rollback();

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response,  $status ?? 200);
    }

    public function update($criteria, Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdateNeighborhoodRequest($data));

            $params = $this->getParamsRequest($request);

            $dataEntity = $this->neighborhood->getItem($criteria, $params);

            if (!$dataEntity) throw new Exception('Item not found', 404);

            $this->neighborhood->update($dataEntity, $data);

            $response = ["data" => "Request successful"];

            DB::commit();
        } catch (Exception $exception) {
            Log::Error($exception);
            DB::rollback();
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response,  $status ?? 200);
    }

    public function delete($criteria, Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->neighborhood->getItem($criteria, $params);

            if (!$dataEntity) throw new Exception('Item not found', 404);

            $this->neighborhood->destroy($dataEntity);

            $response = ["data" => "Request successful"];

            DB::commit();
        } catch (Exception $exception) {
            Log::Error($exception);
            DB::rollback();
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response,  $status ?? 200);
    }

}
