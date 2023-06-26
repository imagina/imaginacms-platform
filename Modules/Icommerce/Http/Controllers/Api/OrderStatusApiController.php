<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\OrderStatusRepository;
// Transformers
use Modules\Icommerce\Transformers\OrderStatusTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class OrderStatusApiController extends BaseApiController
{
    private $orderStatus;

    public function __construct(OrderStatusRepository $orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        try {
            //Request to Repository
            $orderStatuses = $this->orderStatus->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => OrderStatusTransformer::collection($orderStatuses)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($orderStatuses)] : false;
        } catch (\Exception $e) {
            //Message Error
            \Log::error($e->getMessage());
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
            //Request to Repository
            $orderStatus = $this->orderStatus->getItem($criteria, $this->getParamsRequest($request));

            $response = [
                'data' => $orderStatus ? new OrderStatusTransformer($orderStatus) : '',
            ];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        try {
            $this->orderStatus->create($request->all());

            $response = ['data' => ''];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request): Response
    {
        try {
            \DB::beginTransaction();

            $params = $this->getParamsRequest($request);

            $data = $request->all();

            $orderStatus = $this->orderStatus->updateBy($criteria, $data, $params);

            $response = ['data' => new OrderStatusTransformer($orderStatus)];

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
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
        try {
            $this->orderStatus->deleteBy($criteria, $this->getParamsRequest($request));

            $response = ['data' => ''];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
