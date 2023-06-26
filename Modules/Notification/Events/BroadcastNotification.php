<?php

namespace Modules\Notification\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Notification\Entities\Notification;

class BroadcastNotification implements ShouldBroadcast, ShouldQueue
{
    use SerializesModels;

    /**
     * @var Notification
     */
    public $notification;

    public $payload;

    public function __construct(Notification $notification, $payload)
    {
        $this->notification = $notification;
        $this->payload = $payload;
    }

    public function broadcastWith()
    {
        $data = [
            'createdAt' => $this->notification->created_at,
            'entity' => $this->notification->icon_class,
            'id' => $this->notification->id,
            'link' => $this->notification->link,
            'message' => $this->notification->message,
            'timeAgo' => $this->notification->timeAgo,
            'title' => $this->notification->title,
            'type' => $this->notification->type,
            'updatedAt' => $this->notification->updated_at,
            'user' => $this->notification->user_id,
            'options' => $this->notification->options,
            'isAction' => $this->notification->is_action,
            'recipient' => $this->notification->recipient,
        ];
        $data = array_merge($data, $this->payload);

        return $data;
    }

    public function broadcastAs()
    {
        if ($this->notification->recipient) {
            return 'notification.new.'.$this->notification->recipient;
        } else {
            return 'notification.new';
        }
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('imagina.notifications');
    }
}
