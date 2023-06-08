<?php

namespace Modules\Icustom\Http\Controllers\Api;

// Requests & Response

use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;


class SiteApiController extends BaseApiController
{
 
    public function __construct()
    {
    
    }
    
    /**
     * CREATE A ITEM
     * required attributes
     *[
     *  email,
     *  name,
     *  plan(blog | icommerce) array or string,
     *  layout_id
     *
     * ]
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request

            $this->validateRequestApi(new CreateCategoryRequest($data));

            //Create item
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

  
}
