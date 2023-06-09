<?php

namespace Modules\Icommercepricelist\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommercepricelist\Http\Requests\ProductListRequest;
// Base Api
use Modules\Icommercepricelist\Repositories\ProductListRepository;
// Transformers
use Modules\Icommercepricelist\Transformers\ProductListTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ProductListApiController extends BaseApiController
{
    private $productList;

    public function __construct(ProductListRepository $productList)
    {
        $this->productList = $productList;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        try {
            //Request to Repository
            $productLists = $this->productList->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => ProductListTransformer::collection($productLists)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($productLists)] : false;
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /** SHOW
     * @param  Request  $request
     *  URL GET:
     *  &fields = type string
     *  &include = type string
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $criteria = $this->productList->getItem($criteria, $params);

            //Break if no found item
            if (! $criteria) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new ProductListTransformer($criteria)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($criteria)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? []; //Get data

            //Validate Request
            $this->validateRequestApi(new ProductListRequest($data));

            //Create item
            $entity = $this->productList->create($data);

            //Response
            $response = ['data' => new ProductListTransformer($entity)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e);
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdatePriceListRequest($data));

            //Update data
            $category = $this->productList->updateBy($criteria, $data, $params);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Delete data
            $this->productList->deleteBy($criteria, $params);

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
