<?php

namespace Modules\Icurrency\Http\Controllers\Api;

// Requests and Responses
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icurrency\Http\Requests\CreateCurrencyRequest;
use Modules\Icurrency\Http\Requests\UpdateCurrencyRequest;
// Base Api
use Modules\Icurrency\Repositories\CurrencyRepository;
// Entities

// Repository
use Modules\Icurrency\Transformers\CurrencyTransformer;
// Transformer
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CurrencyApiController extends BaseApiController
{
    private $currency;

    public function __construct(CurrencyRepository $currency)
    {
        $this->currency = $currency;
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
            $currencies = $this->currency->getItemsBy($params);
            //Response
            $response = ['data' => CurrencyTransformer::collection($currencies)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($currencies)] : false;
        } catch (\Exception $e) {
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
            $currency = $this->currency->getItem($criteria, $params);
            //Break if no found item
            if (! $currency) {
                throw new Exception('Item not found', 204);
            }
            //Response
            $response = ['data' => new CurrencyTransformer($currency)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($currency)] : false;
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
            $data = $request->input('attributes') ?? []; //Get data
            //Validate Request
            $this->validateRequestApi(new CreateCurrencyRequest($data));
            //Create item
            $currency = $this->currency->create($data);
            //Response
            $response = ['data' => new CurrencyTransformer($currency)];
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
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new UpdateCurrencyRequest($data));
            //Update data
            $currency = $this->currency->updateBy($criteria, $data, $params);
            //Response
            $response = ['data' => $currency];
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
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            //Delete data
            $this->currency->deleteBy($criteria, $params);
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
