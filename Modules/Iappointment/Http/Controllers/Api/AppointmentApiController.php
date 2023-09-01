<?php

namespace Modules\Iappointment\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Iappointment\Http\Requests\CreateAppointmentRequest;
use Modules\Iappointment\Http\Requests\UpdateAppointmentRequest;
use Modules\Iappointment\Repositories\AppointmentRepository;
// Transformers
use Modules\Iappointment\Transformers\AppointmentTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class AppointmentApiController extends BaseApiController
{
    private $appointment;

    public function __construct(AppointmentRepository $appointment)
    {
        $this->appointment = $appointment;
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
            $appointments = $this->appointment->getItemsBy($params);

            //Response
            $response = ['data' => AppointmentTransformer::collection($appointments)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($appointments)] : false;
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
            $appointment = $this->appointment->getItem($criteria, $params);

            //Break if no found item
            if (! $appointment) {
                throw new \Exception('Item not found', 204);
            }

            //Response
            $response = ['data' => new AppointmentTransformer($appointment)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($appointment)] : false;
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

            $this->validateRequestApi(new CreateAppointmentRequest($data));

            //Create item
            $appointment = $this->appointment->create($data);

            //build data for conversation
            $conversationData = [
                'users' => [
                    $data['customer_id'],
                    $data['assigned_to'],
                ],
                'private' => 1,
                'entity_id' => $appointment->id,
                'entity_type' => get_class($appointment),
            ];

            if (setting('iappointment::enableChat') === '1') {
                if (is_module_enabled('Ichat')) {
                    app('Modules\Ichat\Services\ConversationService')->create($conversationData);
                }
            }

            //Response
            $response = ['data' => new AppointmentTransformer($appointment)];
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
    public function update($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        //   try {
        $params = $this->getParamsRequest($request);
        $data = $request->input('attributes');

        //Validate Request
        $this->validateRequestApi(new UpdateAppointmentRequest($data));

        //Update data
        $appointment = $this->appointment->updateBy($criteria, $data, $params);

        //Response
        $response = ['data' => 'Item Updated'];
        \DB::commit(); //Commit to Data Base
        /*   } catch (\Exception $e) {
               \DB::rollback();//Rollback to Data Base
               $status = $this->getStatusError($e->getCode());
               $response = ["errors" => $e->getMessage()];
           }*/
        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Delete data
            $this->appointment->deleteBy($criteria, $params);

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
