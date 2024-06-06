<?php


namespace Modules\Ilocations\Http\Controllers\Api;

// Libs
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

// Custom Requests
use Modules\Ilocations\Http\Requests\CreatePolygonRequest;
use Modules\Ilocations\Http\Requests\UpdatePolygonRequest;

// Transformers
use Modules\Ilocations\Transformers\PolygonTransformer;

// Repositories
use Modules\Ilocations\Repositories\PolygonRepository;

class PolygonApiController extends BaseApiController
{

    private $polygon;

    public function __construct(PolygonRepository $polygon)
    {
        $this->polygon = $polygon;
    }

    public function index(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            $polygons = $this->polygon->getItemsBy($params);

            $response = ['data' => PolygonTransformer::collection($polygons)];

            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($polygons)] : false;


        } catch (\Exception $exception) {
            \Log::Error($exception);
            $status = $this->getStatusError($exception->getCode());
            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    public function show($criteria, Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->polygon->getItem($criteria, $params);

            if (!$dataEntity) throw new \Exception('Item not found', 404);

            $response = ['data' => new PolygonTransformer($dataEntity)];

        } catch (\Exception $exception) {

            \Log::Error($exception);

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new CreatePolygonRequest($data));

            $dataEntity = $this->polygon->create($data);

            $response = ["data" => "Request successful"];

            \DB::commit();
        } catch (\Exception $exception) {

            \Log::Error($exception);

            \DB::rollback();

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];

        }
        return response()->json($response, $status ?? 200);
    }

    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdatePolygonRequest($data));

            $params = $this->getParamsRequest($request);

            $dataEntity = $this->polygon->getItem($criteria, $params);

            if (!$dataEntity) throw new \Exception('Item not found', 404);

            $this->polygon->update($dataEntity, $data);

            $response = ["data" => "Request successful"];

            \DB::commit();
        } catch (\Exception $exception) {

            \Log::Error($exception);

            \DB::rollback();

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->polygon->getItem($criteria, $params);
            if(!$dataEntity) throw new \Exception('Item not found',404);

            $this->polygon->destroy($dataEntity);

            $response = ["data" => "Request successful"];

            \DB::commit();
        } catch (\Exception $exception) {

            \Log::Error($exception);

            \DB::rollback();

            $status = $this->getStatusError($exception->getCode());

            $response = ['errors' => $exception->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

}
