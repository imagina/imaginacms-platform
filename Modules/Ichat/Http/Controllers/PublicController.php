<?php

namespace Modules\Ichat\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ichat\Entities\ConversationUser;
use Modules\Ichat\Repositories\ConversationRepository;
use Modules\Ichat\Repositories\MessageRepository;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PublicController extends BaseApiController
{
  
  private $conversation;
  private $message;
  
  public function __construct(ConversationRepository $conversation, MessageRepository $message)
  {
    parent::__construct();
    
    $this->conversation = $conversation;
    $this->message = $message;
  }
  
  public function getAttachment(Request $request, $conversationId,
                                $messageId, $attachmentId)
  {
    
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
    
      //Request to Repository
      $conversation = $this->conversation->getItem($conversationId, $params);
      
      //Request to Repository
      $message = $this->message->getItem($messageId, $params);
  
     
      if (!isset($conversation->id) || !isset($message->id))
        throw new Exception('Item not found', 404);
  
      $user = \Auth::user();
   
      if(isset($user->id)){
        $conversationUser = ConversationUser::where('user_id', $user->id)->where('conversation_id',$conversation->id)->first();
        if(!isset($conversationUser->id)) throw new Exception('Item not found',404);
      }else{
        throw new Exception('Item not found',404);
      }

      if(empty($message->attachment)) throw new Exception('Item not found',404);
      
      $type = $message->attachment["mimetype"] ?? null;
      
      $privateDisk = config('filesystems.disks.privatemedia');
      $mediaFilesPath = config('asgard.media.config.files-path');
      
      $path = $privateDisk["root"].$mediaFilesPath. $message->mediaFiles()->attachment->filename;
      
      return response()->file($path, [
        'Content-Type' => $type,
      ]);
      
      
    } catch (\Exception $e) {
      return abort(404);
    }
    
  }
  
}