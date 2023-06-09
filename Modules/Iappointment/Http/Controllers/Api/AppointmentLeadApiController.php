<?php

namespace Modules\Iappointment\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Iappointment\Http\Requests\CreateAppointmentLeadRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentLeadRequest;
use Modules\Iappointment\Repositories\AppointmentLeadRepository;
// Transformers
use Modules\Iappointment\Transformers\AppointmentLeadTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class AppointmentLeadApiController extends BaseApiController
{
    private $appointmentLead;

    public function __construct(AppointmentLeadRepository $appointmentLead)
    {
        $this->appointmentLead = $appointmentLead;
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
            $categories = $this->appointmentLead->getItemsBy($params);

            //Response
            $response = ['data' => AppointmentLeadTransformer::collection($categories)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($categories)] : false;
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
            $appointmentLead = $this->appointmentLead->getItem($criteria, $params);

            //Break if no found item
            if (! $appointmentLead) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new AppointmentLeadTransformer($appointmentLead)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($appointmentLead)] : false;
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

            $this->validateRequestApi(new CreateAppointmentLeadRequest($data));

            //Create item
            $this->appointmentLead->create($data);

            //Response
            $response = ['data' => ''];
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
     *
     * @return Response
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdateAppointmentLeadRequest($data));

            //Update data
            $appointmentLead = $this->appointmentLead->updateBy($criteria, $data, $params);

            //Response
            $response = ['data' => 'Item Updated'];
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
     *
     * @return Response
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Delete data
            $this->appointmentLead->deleteBy($criteria, $params);

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
