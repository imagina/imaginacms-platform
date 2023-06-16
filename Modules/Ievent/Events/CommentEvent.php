<?php

namespace Modules\Ievent\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Modules\Icomments\Transformers\CommentTransformer;

class CommentEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $comment;

    public $eventId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($eventId, $comment)
    {
        $this->comment = $comment;
        $this->eventId = $eventId;
    }

    public function broadcastWith()
    {
        // This must always be an array. Since it will be parsed with json_encode()
        return [
            'data' => new CommentTransformer($this->comment),
        ];
    }

    public function broadcastAs()
    {
        return 'event-chat-'.$this->eventId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new Channel('global');
    }
}
