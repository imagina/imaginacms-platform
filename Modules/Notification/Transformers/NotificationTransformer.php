<?php


namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class NotificationTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data=[
            'id'=>$this->when($this->id,$this->id),
            'type'=>$this->when($this->type, $this->type),
            'title'=>$this->when($this->title,$this->title),
            'message'=>$this->when($this->message, $this->message),
            'icon'=>!empty($this->icon_class)?$this->icon_class:'far fa-bell',
            'link'=>$this->when($this->link, $this->link),
            'recipient'=>$this->when($this->recipient, $this->recipient),
            'options'=>$this->when($this->options, $this->options),
            'isRead'=>$this->is_read,
            'timeAgo'=>$this->when($this->timeAgo,$this->timeAgo),
            'createdAt'=>$this->when($this->created_at,$this->created_at),
            'updatedAt'=>$this->when($this->updated_at,$this->updated_at),
            'user'=>new UserTransformer($this->whenLoaded('user')),
        ];

        return $data;
    }
}
