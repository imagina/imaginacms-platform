<?php

namespace Modules\Ichat\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class ConversationUserTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'conversationId' => $this->when($this->conversation_id, $this->conversation_id),
            'userId' => $this->when($this->user_id, $this->user_id),
            'lastMessageReaded' => $this->last_message_readed,
            'unreadMessagesCount' => $this->unread_messages_count,
            'user' => new UserTransformer($this->whenLoaded('user')),
            'conversation' => new ConversationTransformer($this->whenLoaded('conversation')),

        ];

        return $data;
    }
}
