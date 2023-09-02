<?php

namespace Modules\Ichat\Events;

use Illuminate\Queue\SerializesModels;

class MessageWasRetrieved
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
        $this->message = $message;
    }

    /**
     * Get the channels the event should be broadcast on.
     */
    public function broadcastOn()
    {
        return [];
    }
}
