<?php

namespace Modules\Ichat\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class ConversationTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'private' => $this->private ? true : false,
            'status' => $this->status ?? '1',
            /*"lastMessageReaded" => $this->present()->lastMessageReaded,
          "unReadMessages" => $this->present()->unReadMessages,*/
            'lastMessage' => new MessageTransformer($this->whenLoaded('lastMessage')),
            'users' => UserTransformer::collection($this->whenLoaded('users')),
            'messages' => MessageTransformer::collection($this->whenLoaded('messages')),
            'conversationUsers' => ConversationUserTransformer::collection($this->whenLoaded('conversationUsers')),
            'entityType' => $this->when($this->entity_type, $this->entity_type),
            'entityId' => $this->when($this->entity_id, $this->entity_id),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }
}
