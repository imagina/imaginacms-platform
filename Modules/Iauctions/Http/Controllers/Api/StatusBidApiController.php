<?php

namespace Modules\Iauctions\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Iauctions\Entities\StatusBid;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class StatusBidApiController extends BaseApiController
{
    public $model;

    public function __construct(StatusBid $model)
    {
        parent::__construct();
        $this->model = $model;
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

            //Request data to Repository
            $models = $this->model->getAllStatus();

            //Response
            $response = ['data' => $models];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($models)] : false;
        } catch (\Exception $e) {
            \Log::Error($e);
            $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
