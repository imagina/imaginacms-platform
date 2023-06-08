<?php

namespace Modules\Iplaces\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplaces\Http\Requests\CreateScheduleRequest;
use Modules\Iplaces\Http\Requests\UpdateSheduleRequest;
use Modules\Iplaces\Repositories\ScheduleRepository;
use Modules\Iplaces\Transformers\ScheduleTransformer;
use Route;

class ScheduleController extends BaseApiController
{
    private $schedule;

    public function __construct(ScheduleRepository $schedule)
    {
        parent::__construct();
        $this->schedule = $schedule;
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
            $dataEntity = $this->schedule->getItemsBy($params);

            //Response
            $response = ["data" => ScheduleTransformer::collection($dataEntity)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
       * GET A ITEM
       *
       * @param $criteria
       * @return mixed
       */
      public function show($criteria,Request $request)
      {
        try {
          //Get Parameters from URL.
          $params = $this->getParamsRequest($request);

          //Request to Repository
          $dataEntity = $this->schedule->getItem($criteria, $params);

          //Break if no found item
          if(!$dataEntity) throw new \Exception('Item not found',404);

          //Response
          $response = ["data" => new ScheduleTransformer($dataEntity)];

        } catch (\Exception $e) {
          $status = $this->getStatusError($e->getCode());
          $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
      }

      /**
         * CREATE A ITEM
         *
         * @param Request $request
         * @return mixed
         */
        public function create(Request $request)
        {
          \DB::beginTransaction();
          try {
           //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateScheduleRequest((array)$data));

            //Create item
            $this->schedule->create($data);

            //Response
            $response = ["data" => ""];
            \DB::commit(); //Commit to Data Base
          } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
          }
          //Return response
          return response()->json($response, $status ?? 200);
        }

  /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
      \DB::beginTransaction(); //DB Transaction
      try {
        //Get data
        $data = $request->input('attributes');

        //Validate Request
        $this->validateRequestApi(new UpdateSheduleRequest((array)$data));

        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $this->schedule->updateBy($criteria, $data, $params);

        //Response
        $response = ["data" => 'Item Updated'];
        \DB::commit();//Commit to DataBase
      } catch (\Exception $e) {
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response, $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->schedule->deleteBy($criteria, $params);

            //Response
            $response = ["data" => "Item deleted"];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}