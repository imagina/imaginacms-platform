<?php

namespace Modules\Icheckin\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icheckin\Entities\Shift;
use Modules\Icheckin\Events\ShiftWasCheckedIn;
use Modules\Icheckin\Http\Requests\CreateShiftRequest;
use Modules\Icheckin\Http\Requests\UpdateShiftRequest;
use Modules\Icheckin\Repositories\ShiftRepository;
use Modules\Icheckin\Transformers\ShiftTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ShiftApiController extends BaseApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    private $service;

    public function __construct(ShiftRepository $service)
    {
        $this->service = $service;
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

            $params->filter->usersByDepartment = $this->getUsersByDepartment($params);
            //Request to Repository
            $dataEntity = $this->service->getItemsBy($params);

            //Response
            $response = [
                'data' => ShiftTransformer::collection($dataEntity),
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
            $dataEntity = $this->service->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new \Exception('Item not found', 204);
            }

            //Response
            $response = ['data' => $dataEntity ? new ShiftTransformer($dataEntity) : ''];
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
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateShiftRequest((array) $data));

            $checkedAt = Carbon::now()->format('Y-m-d H:i:s');

            // se asigna el checkin al formato fecha Y-m-d H:i:s
            $data['checkin_at'] = $checkedAt;
            $data['checkin_by'] = $params->user->id;

            //Create item
            $shift = $this->service->create($data);

            //Response
            $response = ['data' => new ShiftTransformer($shift)];

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
            $this->validateRequestApi(new UpdateShiftRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            if (! isset($params->permissions['icheckin.shifts.edit']) || ! $params->permissions['icheckin.shifts.edit']) {
                $aux = $data;
                $data = [];
                $data['options'] = $aux['options'];
            }

            //Request to Repository
            $this->service->updateBy($criteria, $data, $params);

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
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function checkin(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CreateShiftRequest((array) $data));

            $checkedAt = Carbon::now()->format('Y-m-d H:i:s');

            // se asigna el checkin al formato fecha Y-m-d H:i:s
            $finalData['checkin_at'] = $checkedAt;
            $finalData['checkin_by'] = $params->user->id;
            $finalData['created_by'] = $params->user->id;
            $finalData['options'] = $data['options'];
            $finalData['geo_location'] = $data['geo_location'];

            //Create item
            $shift = $this->service->create($finalData);

            //shift event
            event(new ShiftWasCheckedIn($shift));

            //Response
            $response = ['data' => new ShiftTransformer($shift)];

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
    public function checkout($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdateShiftRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $checkoutAt = date('Y-m-d H:i:s');

            $finalData['checkout_at'] = $checkoutAt;
            $finalData['checkout_by'] = $params->user->id;
            if (isset($data['options'])) {
                $finalData['options'] = $data['options'];
            }
            if (isset($data['geo_location'])) {
                $finalData['geo_location'] = $data['geo_location'];
            }

            $shift = Shift::find($criteria);
            if (! $shift) {
                throw new \Exception('Shift not found', 404);
            }

            $date1 = new \DateTime($checkoutAt);
            $date2 = new \DateTime($shift->checkin_at);
            $diff = $date1->diff($date2);

            $finalData['period_elapsed'] = $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i) * 60 + $diff->s;

            //Request to Repository
            $shift = $this->service->updateBy($criteria, $finalData, $params);
            //Break if no found item

            //Response
            $response = ['data' => new ShiftTransformer($shift)];
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
            $this->service->deleteBy($criteria, $params);

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
}
