<?php

namespace Modules\Iappointment\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Iappointment\Http\Requests\CreateAppointmentStatusRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentStatusRequest;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Iappointment\Transformers\AppointmentStatusTransformer;

// Entities
use Modules\Iappointment\Entities\AppointmentStatus;

// Repositories
use Modules\Iappointment\Repositories\AppointmentStatusRepository;

class AppointmentStatusApiController extends BaseApiController
{
    private $appointmentStatus;

    public function __construct(AppointmentStatusRepository $appointmentStatus)
    {
        $this->appointmentStatus = $appointmentStatus;
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
            $categories = $this->appointmentStatus->getItemsBy($params);

            //Response
            $response = ["data" => AppointmentStatusTransformer::collection($categories)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($categories)] : false;
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
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $appointmentStatus = $this->appointmentStatus->getItem($criteria, $params);

            //Break if no found item
            if (!$appointmentStatus) throw new \Exception('Item not found', 404);

            //Response
            $response = ["data" => new AppointmentStatusTransformer($appointmentStatus)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($appointmentStatus)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request

            $this->validateRequestApi(new CreateAppointmentStatusRequest($data));

            //Create item
            $appointmentStatus = $this->appointmentStatus->create($data);

            //Response
            $response = ["data" => new AppointmentStatusTransformer($appointmentStatus)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update($criteria, Request $request)
    {


        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdateAppointmentStatusRequest($data));

            //Update data
            $appointmentStatus = $this->appointmentStatus->updateBy($criteria, $data,$params);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Delete data
            $this->appointmentStatus->deleteBy($criteria, $params);

            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }
}
