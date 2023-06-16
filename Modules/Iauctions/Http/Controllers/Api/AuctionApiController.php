<?php

namespace Modules\Iauctions\Http\Controllers\Api;

use Illuminate\Http\Request;
//Model
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Core\Icrud\Transformers\CrudResource;
// Testing
use Modules\Iauctions\Entities\Auction;
use Modules\Iauctions\Repositories\AuctionRepository;

class AuctionApiController extends BaseCrudController
{
    public $model;

    public $modelRepository;

    public function __construct(Auction $model, AuctionRepository $modelRepository)
    {
        $this->model = $model;
        $this->modelRepository = $modelRepository;
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

            //Create model
            $model = $this->modelRepository->create($modelData);

            //Create a Comment for this Rating
            if (isset($modelData['comment'])) {
                $createdComment = app('Modules\Icomments\Services\CommentService')->create($model, $modelData['comment']);
            }

            //Response
            $response = ['data' => CrudResource::transformData($model)];
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
     * Controller to update model by criteria
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \Log::info('Iauctions: Update|Auction');

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
            $auction = $this->modelRepository->getItem($criteria, $params);

            //Throw exception if no found item
            if (! $auction) {
                throw new Exception('Item not found', 204);
            }

            // Only update if status is 0 (INACTIVE)
            /*
            if($auction->status!=0)
              throw new \Exception(trans('iauctions::auctions.validation.has to be inactive to update'), 500);
            */

            // Only update status Auction
            if (isset($modelData['status']) && count($modelData) == 1) {
                $modelDataFormat['status'] = $modelData['status'];

                //Update model
                $model = $this->modelRepository->updateBy($criteria, $modelDataFormat, $params);
            } else {
                throw new \Exception(trans('iauctions::auctions.validation.only update status'), 500);
            }

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
