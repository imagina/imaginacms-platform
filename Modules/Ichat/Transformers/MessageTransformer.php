<?php

namespace Modules\Ichat\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class MessageTransformer extends JsonResource
{
  public function toArray($request)
  {
    
    return [
      'id' => $this->id,
      'type' => $this->when($this->type, $this->type),
      'body' => $this->when($this->body, $this->body),
      'attached' => $this->when($this->attached, $this->attached),
      'attachment' => $this->when($this->attached, $this->attachment),
      'conversationId' => $this->when($this->conversation_id, $this->conversation_id),
      'userId' => $this->when($this->user_id, $this->user_id),
      'replyToId' => $this->when($this->reply_to_id, $this->reply_to_id),
      'user' => new UserTransformer ($this->whenLoaded('user')),
      'replyTo' => new MessageTransformer($this->whenLoaded('replyTo')),
      'conversation' => new ConversationTransformer ($this->whenLoaded('conversation')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
    ];
  }
}
