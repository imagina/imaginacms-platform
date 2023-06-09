<?php

namespace Modules\Ievent\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ievent\Http\Requests\CreateEventRequest;
use Modules\Ievent\Http\Requests\UpdateEventRequest;
use Modules\Ievent\Repositories\EventRepository;
use Modules\Ievent\Transformers\EventPublicTransformer;
use Modules\Ievent\Transformers\EventTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Services\Inotification;

class EventApiController extends BaseApiController
{
    private $event;

    private $notification;

    public function __construct(EventRepository $event, Inotification $notification)
    {
        $this->event = $event;
        $this->notification = $notification;
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
            $events = $this->event->getItemsBy($params);

            //Response
            $response = [
                'data' => EventTransformer::collection($events),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($events)] : false;
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
            $event = $this->event->getItem($criteria, $params);

            //Break if no found item
            if (! $event) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new EventTransformer($event)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($event)] : false;
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

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Validate Request
            $this->validateRequestApi(new CreateEventRequest((array) $data));

            $data['user_id'] = $params->user->id;
            //$data["department_id"] = $params->department->id;
            //Create item
            $event = $this->event->create($data);

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

            unset($data['department_id']);
            //Validate Request
            $this->validateRequestApi(new UpdateEventRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $event = $this->event->updateBy($criteria, $data, $params);

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
            $this->event->deleteBy($criteria, $params);

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
     * GET A ITEM PUBLIC
     *
     * @return mixed
     */
    public function showPublic($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $event = $this->event->getItem($criteria, $params);

            //Break if no found item
            if (! $event) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new EventPublicTransformer($event)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($event)] : false;
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }
}
