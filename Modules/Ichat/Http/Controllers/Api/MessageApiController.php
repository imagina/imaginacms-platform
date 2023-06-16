<?php

namespace Modules\Ichat\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ichat\Http\Requests\CreateMessageRequest;
use Modules\Ichat\Http\Requests\UpdateMessageRequest;
use Modules\Ichat\Repositories\MessageRepository;
use Modules\Ichat\Services\MessageService;
use Modules\Ichat\Transformers\MessageTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class MessageApiController extends BaseApiController
{
    private $message;

    private $messageService;

    public function __construct(MessageRepository $message, MessageService $messageService)
    {
        $this->message = $message;
        $this->messageService = $messageService;
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        try {
            $data = $request->input('attributes') ?? []; //Get data
            //Validate Request
            $this->validateRequestApi(new CreateMessageRequest($data));
            //Map the message data
            $messageParsed = [
                'message' => $data['message'] ?? $data['body'] ?? null,
                'provider' => $data['provider'] ?? null,
                'recipient_id' => $data['recipient_id'] ?? null,
                'sender_id' => $data['user_id'] ?? $data['sender_id'] ?? null,
                'first_name' => $data['first_name'] ?? null,
                'conversation_id' => $data['conversation_id'] ?? null,
                'conversation_private' => $data['conversation_private'] ?? 1,
                'media_id' => $data['media_id'] ?? $data['attached'] ?? null,
                'send_to_provider' => true,
                'template' => $data['template'] ?? null,
            ];
            //Create message
            $result = $this->messageService->create($messageParsed);
            //Response
            $response = ['data' => collect(new MessageTransformer($result['data']['message']))
              ->put('frontId', $data['front_id'] ?? null)];
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
            $data = $this->message->getItemsBy($params);
            //Response
            $response = ['data' => MessageTransformer::collection($data)];
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
            $data = $this->message->getItem($criteria, $params);
            //Break if no found item
            if (! $data) {
                throw new Exception('Item not found', 204);
            }
            //Response
            $response = ['data' => new MessageTransformer($data)];
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
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new UpdateMessageRequest($data));
            //Update data
            $this->message->updateBy($criteria, $data, $params);
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
            $this->message->deleteBy($criteria, $params);
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
