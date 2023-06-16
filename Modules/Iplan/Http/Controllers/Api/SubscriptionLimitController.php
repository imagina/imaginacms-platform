<?php

namespace Modules\Iplan\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplan\Http\Requests\CreateSubscriptionLimitRequest;
use Modules\Iplan\Http\Requests\UpdateSubscriptionLimitRequest;
use Modules\Iplan\Repositories\SubscriptionLimitRepository;
use Modules\Iplan\Transformers\SubscriptionLimitTransformer;

class SubscriptionLimitController extends BaseApiController
{
    private $subscriptionLimit;

    public function __construct(SubscriptionLimitRepository $subscriptionLimit)
    {
        parent::__construct();
        $this->subscriptionLimit = $subscriptionLimit;
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
            $dataEntity = $this->subscriptionLimit->getItemsBy($params);

            //Response
            $response = [
                'data' => SubscriptionLimitTransformer::collection($dataEntity),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
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
            $dataEntity = $this->subscriptionLimit->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new SubscriptionLimitTransformer($dataEntity)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
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
            $this->validateRequestApi(new CreateSubscriptionLimitRequest((array) $data));

            //Create item
            $entity = $this->subscriptionLimit->create($data);

            //Response
            $response = ['data' => $entity];
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
            $this->validateRequestApi(new UpdateSubscriptionLimitRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->subscriptionLimit->updateBy($criteria, $data, $params);

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

            //call Method delete
            $this->subscriptionLimit->deleteBy($criteria, $params);

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
}
