<?php

namespace Modules\Ilocations\Http\Controllers\Api;

// Libs
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
// Custom Requests
use Modules\Ilocations\Http\Requests\CreateCityRequest;
use Modules\Ilocations\Http\Requests\UpdateCityRequest;
// Transformers
use Modules\Ilocations\Repositories\CityRepository;
// Repositories
use Modules\Ilocations\Transformers\CityTransformer;

class CityApiController extends BaseApiController
{
    /**
     * @var Application
     */
    private $city;

    public function __construct(CityRepository $city)
    {
        $this->city = $city;
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
            $dataEntity = $this->city->getItemsBy($params);

            //Response
            $response = ['data' => CityTransformer::collection($dataEntity)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CityTransformer($dataEntity)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new CreateCityRequest($data));

            $dataEntity = $this->city->create($data);

            $response = ['data' => 'Request successful'];

            \DB::commit();
        } catch (Exception $exception) {
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

            $this->validateRequestApi(new UpdateCityRequest($data));

            $params = $this->getParamsRequest($request);

            $dataEntity = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new Exception('Item not found', 404);
            }

            $this->city->update($dataEntity, $data);

            $response = ['data' => 'Request successful'];

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

            $dataEntity = $this->city->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new Exception('Item not found', 404);
            }

            $this->city->destroy($dataEntity);

            $response = ['data' => 'Request successful'];

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
