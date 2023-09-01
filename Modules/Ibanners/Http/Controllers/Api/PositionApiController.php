<?php

namespace Modules\Ibanners\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Modules\Ibanners\Http\Requests\UpdatePositionRequest;
use Modules\Ibanners\Repositories\Eloquent\EloquentPositionRepository;
use Modules\Ibanners\Repositories\PositionRepository;
use Modules\Ibanners\Services\BannerOrderer;
use Modules\Ibanners\Transformers\PositionApiTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PositionApiController extends BaseApiController
{
    /**
     * @var Repository
     */
    private $cache;

    /**
     * @var BannerOrderer
     */
    private $bannerOrderer;

    /**
     * @var EloquentPositionRepository
     */
    private $position;

    public function __construct(PositionRepository $position, BannerOrderer $bannerOrderer)
    {
        $this->position = $position;
        $this->bannerOrderer = $bannerOrderer;
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
            $positions = $this->position->getItemsBy($params);

            //Response
            $response = [
                'data' => PositionApiTransformer::collection($positions),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($positions)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Show banner by id
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $position = $this->position->getItem($criteria, $params);
            //Break if no found item
            if (! $position) {
                throw new Exception('Item not found', 204);
            }
            //Response
            $response = ['data' => new PositionApiTransformer($position)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($position)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            // $this->validateRequestApi(new CustomRequest((array)$data));

            //Create item
            $this->position->create($data);

            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            //$this->validateRequestApi(new UpdatePositionRequest((array)$data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            $dataEntity = $this->position->getItem($criteria, $params);

            if (! $dataEntity) {
                throw new Exception('Item not found', 204);
            }

            //Request to Repository
            $this->position->update($dataEntity, $data);

            if (isset($data['banners'])) {
                $this->bannerOrderer->handle(json_encode($data['banners']));
            }

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            //Delete data
            $this->position->deleteBy($criteria, $params);
            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }
}
