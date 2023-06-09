<?php

namespace Modules\Iforms\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Iforms\Entities\Type;
// Transformers

// Entity
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class TypeApiController extends BaseApiController
{
    private $types;

    public function __construct(Type $formTypes)
    {
        parent::__construct();
        $this->types = $formTypes;
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
            $dataEntity = $this->types->lists();
            //Response
            $response = ['data' => $dataEntity];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
