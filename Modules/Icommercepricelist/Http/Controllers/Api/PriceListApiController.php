<?php

namespace Modules\Icommercepricelist\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommercepricelist\Http\Requests\PriceListRequest;
use Modules\Icommercepricelist\Http\Requests\UpdatePriceListRequest;
// Base Api
use Modules\Icommercepricelist\Repositories\PriceListRepository;
// Transformers
use Modules\Icommercepricelist\Transformers\PriceListTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PriceListApiController extends BaseApiController
{
    private $criteria;

    public function __construct(PriceListRepository $priceList)
    {
        $this->priceList = $priceList;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            //Request to Repository
            $priceLists = $this->priceList->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => PriceListTransformer::collection($priceLists)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($priceLists)] : false;
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
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $criteria = $this->priceList->getItem($criteria, $params);

            //Break if no found item
            if (! $criteria) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new PriceListTransformer($criteria)];

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
     *
     * @return Response
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? []; //Get data
            //Validate Request
            $this->validateRequestApi(new PriceListRequest($data));

            //Create item
            $entity = $this->priceList->create($data);
            //Fresh data
            $entity = $entity->fresh();
            //Job
            if (isset($data['productIds']) && $entity->criteria == 'percentage') {
                \Modules\Icommerce\Jobs\SaveProductsPriceLists::dispatch(json_decode($data['productIds']), $entity);
            }

            //Response
            $response = ['data' => new PriceListTransformer($entity)];
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
     *
     * @return Response
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdatePriceListRequest($data));

            //Update data
            $category = $this->priceList->updateBy($criteria, $data, $params);

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
     *
     * @return Response
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Delete data
            $this->priceList->deleteBy($criteria, $params);

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
