<?php

namespace Modules\Ichat\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\CountValidator\Exception;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Notification\Entities\Provider;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Modules\Ichat\Services\MessageService;

class ProviderApiController extends BaseApiController
{
  private $messageService;

  public function __construct(MessageService $messageService)
  {
    $this->messageService = $messageService;
  }

  /** Create conversation of provider */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      $data = $request->input("attributes");
      //Map data for create the conversation
      $data = [
        "provider" => $data["provider"],
        "recipient_id" => $data["conversation_id"],
        "first_name" => $data["first_name"],
        "last_name" => $data["last_name"],
        "conversation_private" => 0
      ];
      //Create Users
      $conversationUsers = $this->messageService->getConversationUsers($data);
      $data["users"] = $conversationUsers["users"];
      $conversation = $this->messageService->getConversation($data);
      //Set response
      $response = ["data" => $conversation];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /** Validate Webhook of provider */
  public function validateWebhook($provider, Request $request)
  {
    //Validate webhook
    switch ($provider) {
      case "whatsapp":
        $responseToken = $request->query("hub_challenge") ?? 0;
        return response()->json((int)$responseToken, 200);
        break;
    }

    //Default abort 404
    return abort(404);
  }

  /** Handle provider Webhook */
  public function handleWebhook($providerName, Request $request)
  {
    try {
      //Get data
      $payload = $request->all();
      //Log info
      \Log::info("[handleWebhook]:: in progress" . json_encode($payload));
      //Get provider data
      $provider = Provider::where('system_name', $providerName)->first();
      //Validate the provider
      if (!$provider || !$provider->status || !isset($provider->fields))
        throw new Exception("Provider '{$providerName}' not found", 400);
      //Parse the message by provider
      $data = $this->{"get" . Str::title($providerName) . "Message"}($payload, $provider);
      //Manage message
      if ($data) {
        //Instance the message service
        $messageServices = app("Modules\Ichat\Services\MessageService");
        //Create the message
        $messageServices->create(array_merge(["provider" => $providerName], $data));
      }
      //Log info
      \Log::info("[handleWebhook]:: Success");
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      \Log::info("[handleWebhook]::{$provider}. Error -> " . $e->getMessage());
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /** Return the Whatsapp messages data  */
  private function getWhatsappMessage($data, $provider)
  {
    try {
      //Get attributes from the message
      $contact = $data["entry"][0]["changes"][0]["value"]["contacts"][0] ?? null;
      $message = $data["entry"][0]["changes"][0]["value"]["messages"][0] ?? null;
      //Validate message
      if (!$message) return null;
      //Get date entry message
      /*$messageDate = $message["timestamp"] ?? null;
      if ($messageDate) {
        $dateTmp = new \DateTime();
        $dateTmp->setTimestamp($messageDate);
        $messageDate = $dateTmp->format("Y-m-d H:m:s");
      }*/
      //Instance the response
      $response = [
        "recipient_id" => $message["from"],
        "first_name" => $contact["profile"]["name"] ?? null,
        "message" => $message["text"]["body"] ?? $message["button"]["text"] ?? null
        //"created_at" => $messageDate
      ];
      //Get file
      if (in_array($message["type"], ["video", "document", "image", "audio", "sticker"])) {
        //Request File url
        $client = new \GuzzleHttp\Client();
        $fileResponse = $client->request('GET',
          "https://graph.facebook.com/v15.0/{$message[$message["type"]]["id"]}",
          ['headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$provider->fields->accessToken}",
          ]]
        );
        $fileResponse = json_decode($fileResponse->getBody()->getContents());
        //Set file to response
        $response["file"] = $fileResponse->url;
        //Set file request context
        $response["file_context"] = [
          'header' => "User-Agent: php/7 \r\n" .
            "Authorization: Bearer {$provider->fields->accessToken}"
        ];
        //Replace the message text by the file caption
        $response["message"] = $message[$message["type"]]["caption"] ?? null;
      }
      //Response
      return $response;
    } catch (\Exception $e) {
      throw new Exception('whatsappBusiness::Issue parsing the message: ' . $e->getMessage(), 500);
    }
  }
}
