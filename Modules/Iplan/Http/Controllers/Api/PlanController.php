<?php

namespace Modules\Iplan\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Iplan\Entities\Plan;
use Modules\Iplan\Http\Requests\CreatePlanRequest;
use Modules\Iplan\Http\Requests\UpdatePlanRequest;
use Modules\Iplan\Repositories\PlanRepository;
use Modules\Iplan\Transformers\PlanTransformer;

class PlanController extends BaseApiController
{
    private $plan;

    public function __construct(PlanRepository $plan)
    {
        parent::__construct();
        $this->plan = $plan;
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
            $dataEntity = $this->plan->getItemsBy($params);

            //Response
            $response = [
                'data' => PlanTransformer::collection($dataEntity),
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
            $dataEntity = $this->plan->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new PlanTransformer($dataEntity)];
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
            $this->validateRequestApi(new CreatePlanRequest((array) $data));

            //Create item
            $entity = $this->plan->create($data);

            if (! empty($data['limits'])) {
                $entity->limits()->sync($data['limits']);
            }

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
            $this->validateRequestApi(new UpdatePlanRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $plan = $this->plan->updateBy($criteria, $data, $params);
            if (! empty($data['limits'])) {
                $plan->limits()->sync($data['limits']);
            }

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
            $this->plan->deleteBy($criteria, $params);

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
       * GET PLAN FREQUENCIES
       *
       * @return mixed
       */
      public function frequencies(Request $request)
      {
          try {
              //Response
              $response = [
                  'data' => app('Modules\Iplan\Entities\Frequency')->lists(),
              ];
          } catch (\Exception $e) {
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
      public function modules(Request $request)
      {
          try {
              $modulesEnabled = app('modules')->allEnabled();
              $data = [];

              foreach ($modulesEnabled as $name => $module) {
                  $cfg = config('asgard.'.strtolower($name).'.config.limitableEntities');
                  if (! empty($cfg)) {
                      $data[] = [
                          'label' => $name,
                          'value' => $name,
                          'entities' => $cfg,
                      ];
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
