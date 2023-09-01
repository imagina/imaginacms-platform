<?php

namespace Modules\Iauctions\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Default transformer
use Modules\Core\Icrud\Transformers\CrudResource;
//Model
use Modules\Iauctions\Entities\Bid;
use Modules\Iauctions\Repositories\BidRepository;

class BidApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public $bidService;

    public function __construct(Bid $model, BidRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
        $this->bidService = app('Modules\Iauctions\Services\BidService');
    }

    /**
     * Controller to create model
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get model data
            $modelData = $request->input('attributes') ?? [];

            //Validate Request
            if (isset($this->model->requestValidation['create'])) {
                $this->validateRequestApi(new $this->model->requestValidation['create']($modelData));
            }

            //Bid Service to Validate and Create BID
            $model = $this->bidService->create($modelData);

            //Response
            $response = ['data' => CrudResource::transformData($model)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            //$status = $this->getStatusError($e->getCode());
            //$response = ["errors" => $e->getMessage()];
            $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Controller to update model by criteria
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get model data
            $modelData = $request->input('attributes') ?? [];
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Validate Request
            if (isset($this->model->requestValidation['update'])) {
                $this->validateRequestApi(new $this->model->requestValidation['update']($modelData));
            }

            // search
            $bid = $this->modelRepository->getItem($criteria, $params);

            //Throw exception if no found item
            if (! $bid) {
                throw new Exception('Item not found', 204);
            }

            // Update Winner Manually (Winner 1 in Request)
            if (isset($modelData['winner']) && $modelData['winner']) {
                $auction = $bid->auction;

                if ($auction->type == 0) {
                    throw new \Exception(trans('iauctions::auctions.validation.type not open'), 500);
                }

                if ($auction->status != 2) {
                    throw new \Exception(trans('iauctions::auctions.validation.not finished'), 500);
                }

                if (! is_null($auction->winner_id)) {
                    throw new \Exception(trans('iauctions::auctions.validation.has a winner'), 500);
                }
            }

            //Update model
            $model = $this->modelRepository->updateBy($criteria, $modelData, $params);

            //Response
            $response = ['data' => CrudResource::transformData($model)];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            //$status = $this->getStatusError($e->getCode());
            //$response = ["errors" => $e->getMessage()];
            $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
