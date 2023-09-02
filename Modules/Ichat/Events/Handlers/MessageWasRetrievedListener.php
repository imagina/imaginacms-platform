<?php

namespace Modules\Ichat\Events\Handlers;

use Illuminate\Support\Facades\Auth;
use Modules\Ichat\Entities\ConversationUser;

class MessageWasRetrievedListener
{
    private $conversationUser;

    public function __construct(ConversationUser $conversationUser)
    {
        $this->conversationUser = $conversationUser;
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        //Get message
        $message = $event->message;
        //Get model
        $model = ConversationUser::where('conversation_id', $message->conversation_id)
          ->where('user_id', AUTH::user()->id)->first();
        //update last message read
        if ($model && $message) {
            $model->update(['last_message_readed' => $message->id, 'unread_messages_count' => 0]);
        }
    }
}
