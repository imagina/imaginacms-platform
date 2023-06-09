<?php

namespace Modules\Ichat\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ichat\Http\Requests\CreateConversationRequest;
use Modules\Ichat\Http\Requests\UpdateConversationRequest;
use Modules\Ichat\Repositories\ConversationRepository;
use Modules\Ichat\Transformers\ConversationTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ConversationApiController extends BaseApiController
{
    private $conversation;

    public function __construct(ConversationRepository $conversation)
    {
        $this->conversation = $conversation;
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
            $this->validateRequestApi(new CreateConversationRequest($data));
            //Create item
            $conversation = $this->conversation->create($data);
            //Response
            $response = ['data' => new ConversationTransformer($conversation)];
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
            $data = $this->conversation->getItemsBy($params);
            //Response
            $response = ['data' => ConversationTransformer::collection($data)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($data)] : false;
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
            $data = $this->conversation->getItem($criteria, $params);
            //Break if no found item
            if (! $data) {
                throw new \Exception('Item not found', 204);
            }
            //Response
            $response = ['data' => new ConversationTransformer($data)];
            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($data)] : false;
        } catch (\Exception $e) {
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
    public function update($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new UpdateConversationRequest($data));
            //Get params
            $params = $this->getParamsRequest($request);
            //Update data
            $this->conversation->updateBy($criteria, $data, $params);
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
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);
            //Delete data
            $this->conversation->deleteBy($criteria, $params);
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
