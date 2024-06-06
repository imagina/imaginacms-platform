<?php


namespace Modules\Ilocations\Http\Controllers\Api;

// Libs
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

// Custom Requests
use Modules\Ilocations\Http\Requests\CreateGeozonesRequest;
use Modules\Ilocations\Http\Requests\UpdateGeozonesRequest;

// Transformers
use Modules\Ilocations\Transformers\GeozoneTransformer;

// Repositories
use Modules\Ilocations\Repositories\GeozonesRepository;

class GeozoneApiController extends BaseApiController
{

    private $dataEntity;

    public function __construct(GeozonesRepository $dataEntity)
    {
        $this->geozone = $dataEntity;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);

            $geozones = $this->geozone->getItemsBy($params);

            $response = ['data' => GeozoneTransformer::collection($geozones)];

            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($geozones)] : false;

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

            $dataEntity = $this->geozone->getItem($criteria, $params);

            if (!$dataEntity) throw new \Exception('Item not found', 404);

            $response = ['data' => new GeozoneTransformer($dataEntity)];

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

            $this->validateRequestApi(new CreateGeozonesRequest($data));

            $dataEntity = $this->geozone->create($data);

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

            $this->validateRequestApi(new UpdateGeozonesRequest($data));

            $params = $this->getParamsRequest($request);

            $dataEntity = $this->geozone->getItem($criteria, $params);


            if (!$dataEntity) throw new \Exception('Item not found', 404);

            $this->geozone->update($dataEntity, $data);

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

            $dataEntity = $this->geozone->getItem($criteria, $params);

            if(!$dataEntity) throw new \Exception('Item not found',404);

            $this->geozone->destroy($dataEntity);

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
