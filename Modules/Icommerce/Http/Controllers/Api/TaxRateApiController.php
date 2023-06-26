<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\TaxRateRequest;
// Base Api
use Modules\Icommerce\Repositories\TaxRateRepository;
// Transformers
use Modules\Icommerce\Transformers\TaxRateTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class TaxRateApiController extends BaseApiController
{
    private $taxRate;

    public function __construct(TaxRateRepository $taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        //return $request;
        try {
            //Request to Repository
            $taxRates = $this->taxRate->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => TaxRateTransformer::collection($taxRates)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($taxRates)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
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
            $taxRate = $this->taxRate->getItem($criteria, $params);

            //Break if no found item
            if (! $taxRate) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new TaxRateTransformer($taxRate)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
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
            $this->validateRequestApi(new TaxRateRequest($data));

            $taxRate = $this->taxRate->create($data);

            //Response
            $response = ['data' => new TaxRateTransformer($taxRate)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
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
        \DB::beginTransaction(); //DB Transaction
        try {
            $data = $request->input('attributes') ?? []; //Get data

            $params = $this->getParamsRequest($request);

            $this->taxRate->updateBy($criteria, $data, $params);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $this->taxRate->deleteBy($criteria, $this->getParamsRequest($request));

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
