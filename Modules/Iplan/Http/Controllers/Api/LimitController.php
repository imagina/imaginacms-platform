<?php

namespace Modules\Iplan\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplan\Http\Requests\CreateLimitRequest;
use Modules\Iplan\Http\Requests\UpdateLimitRequest;
use Modules\Iplan\Repositories\LimitRepository;
use Modules\Iplan\Transformers\LimitTransformer;

class LimitController extends BaseApiController
{
    private $limit;

    public function __construct(LimitRepository $limit)
    {
        parent::__construct();
        $this->limit = $limit;
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
            $dataEntity = $this->limit->getItemsBy($params);

            //Response
            $response = [
                'data' => LimitTransformer::collection($dataEntity),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
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
            $dataEntity = $this->limit->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new LimitTransformer($dataEntity)];
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
            $this->validateRequestApi(new CreateLimitRequest((array) $data));

            //Create item
            $entity = $this->limit->create($data);

            //Response
            $response = ['data' => $entity];
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
            $this->validateRequestApi(new UpdateLimitRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->limit->updateBy($criteria, $data, $params);

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
            $this->limit->deleteBy($criteria, $params);

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
       * GET ITEMS
       *
       * @return mixed
       */
      public function entities(Request $request)
      {
          try {
              $modulesEnabled = app('modules')->allEnabled();
              $data = [];

              foreach ($modulesEnabled as $name => $module) {
                  $cfg = config('asgard.'.strtolower($name).'.config.limitEntities');
                  if (! empty($cfg)) {
                      $data = array_merge($data, $cfg);
                  }
              }

              //Response
              $response = [
                  'data' => $data,
              ];
          } catch (\Exception $e) {
              $status = $this->getStatusError($e->getCode());
              $response = ['errors' => $e->getMessage()];
          }

          //Return response
          return response()->json($response, $status ?? 200);
      }
}
