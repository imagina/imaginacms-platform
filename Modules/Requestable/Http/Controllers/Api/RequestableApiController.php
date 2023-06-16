<?php

namespace Modules\Requestable\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
use Modules\Requestable\Entities\Requestable;
use Modules\Requestable\Events\RequestableWasCreated;
use Modules\Requestable\Events\RequestableWasUpdated;
use Modules\Requestable\Http\Requests\CreateRequestableRequest;
use Modules\Requestable\Http\Requests\UpdateRequestableRequest;
use Modules\Requestable\Repositories\RequestableRepository;
// Events
use Modules\Requestable\Services\RequestableService;
use Modules\Requestable\Transformers\RequestableTransformer;

class RequestableApiController extends BaseCrudController
{
    private $requestable;

    private $service;

    public $model;

    public $modelRepository;

    public function __construct(RequestableRepository $requestable, RequestableService $service, Requestable $model)
    {
        parent::__construct();
        $this->requestable = $requestable;
        $this->service = $service;
        $this->model = $model;
        $this->modelRepository = $requestable;
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
            $newRequest = $this->requestable->getItemsBy($params);

            //Response
            $response = [
                'data' => RequestableTransformer::collection($newRequest),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($newRequest)] : false;
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
    public function config(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            //$newRequest = $this->requestable->getItemsBy($params);

            //Response
            $response = [
                'data' => config('asgard.requestable.config.requests'),
            ];

            //If request pagination add meta-page
            //$params->page ? $response["meta"] = ["page" => $this->pageTransformer($newRequest)] : false;
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
            $newRequest = $this->requestable->getItem($criteria, $params);

            //Break if no found item
            if (! $newRequest) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new RequestableTransformer($newRequest)];
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
            $this->validateRequestApi(new CreateRequestableRequest((array) $data));

            //Validate with Permission
            $data = $this->service->validateCreatedBy($data, $params);

            $model = $this->service->create($data);

            event(new RequestableWasCreated($model));

            //Response
            $response = ['data' => new RequestableTransformer($model)];

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
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new UpdateRequestableRequest((array) $data));

            //Validate with Permission
            $data = $this->service->validateCreatedBy($data, $params);

            $model = $this->service->update($criteria, $data, $params);

            event(new RequestableWasUpdated($model));

            //Response
            //$response = ["data" => 'Item Updated'];

            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
      //dd($e);
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Item Updated'], $status ?? 200);
    }

    /**
     * Add comment to requestable
     *
     * @param $criteria (requestable id)
     */
    public function addComment($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new \Modules\Icomments\Http\Requests\CreateCommentRequest((array) $data));

            // Search
            $model = $this->requestable->getItem($criteria, $params);

            //Break if no found item
            if (! $model) {
                throw new \Exception('Item not found', 404);
            }

            //Create comment
            $comment = app('Modules\Icomments\Services\CommentService')->create($model, $data);

            //Response
            $response = ['data' => new \Modules\Icomments\Transformers\CommentTransformer($comment)];

            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
      //dd($e);
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Comment Added'], $status ?? 200);
    }
}
