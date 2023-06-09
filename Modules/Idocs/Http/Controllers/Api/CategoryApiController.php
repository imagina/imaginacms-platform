<?php

namespace Modules\Idocs\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Idocs\Repositories\CategoryRepository;
use Modules\Idocs\Transformers\CategoryTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CategoryApiController extends BaseApiController
{
    private $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Get Data from Categories
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $categories = $this->category->getItemsBy($params);

            //Response
            $response = ['data' => CategoryTransformer::collection($categories)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($categories)] : false;
        } catch (\Exception $e) {
            Log::Error($e);
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
            $category = $this->category->getItem($criteria, $params);

            //Break if no found item
            if (! $category) {
                throw new Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CategoryTransformer($category)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Create a Category
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? []; //Get data

            //Create item
            $category = $this->category->create($data);

            //Response
            $response = ['data' => new CategoryTransformer($category)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Update a Category
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
      //Get data
            $data = $request->input('attributes') ?? []; //Get data

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $category = $this->category->getItem($criteria, $params);

            //Request to Repository
            $this->category->update($category, $data);

            //Response
            $response = ['data' => trans('iblog::common.messages.resource updated')];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Delete a Category
     *
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $category = $this->category->getItem($criteria, $params);
            //call Method delete
            $this->category->destroy($category);

            //Response
            $response = ['data' => trans('iblog::common.messages.resource deleted')];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
