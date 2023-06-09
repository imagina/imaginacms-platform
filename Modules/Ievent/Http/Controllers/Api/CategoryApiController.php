<?php

namespace Modules\Ievent\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ievent\Http\Requests\CreateCategoryRequest;
use Modules\Ievent\Http\Requests\UpdateCategoryRequest;
use Modules\Ievent\Repositories\CategoryRepository;
use Modules\Ievent\Transformers\CategoryTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CategoryApiController extends BaseApiController
{
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
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
            $categories = $this->category->getItemsBy($params);

            //Response
            $response = [
                'data' => CategoryTransformer::collection($categories),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($categories)] : false;
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
            $category = $this->category->getItem($criteria, $params);

            //Break if no found item
            if (! $category) {
                throw new Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CategoryTransformer($category)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($category)] : false;
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
            $this->validateRequestApi(new CreateCategoryRequest((array) $data));

            //Create item
            $this->category->create($data);

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
            $this->validateRequestApi(new UpdateCategoryRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->category->updateBy($criteria, $data, $params);

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
            $this->category->deleteBy($criteria, $params);

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
