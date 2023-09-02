<?php

namespace Modules\Ichat\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Ichat\Entities\Message;

class MessageWasSaved
{
    use SerializesModels;

    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = Message::with(['user', 'conversation.users', 'conversation.conversationUsers'])
          ->where('id', $message->id)
          ->first();
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return [];
    }
}
