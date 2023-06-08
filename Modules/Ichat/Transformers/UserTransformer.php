<?php

namespace Modules\Ichat\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;

class UserTransformer extends JsonResource
{
  public function toArray($request)
  {
    $smallImage = $this->fields()->where('name','smallImage')->first();
    $mediumImage = $this->fields()->where('name','mediumImage')->first();
    $mainImage = $this->fields()->where('name','mainImage')->first();

    return [
      'id' => $this->when($this->id, $this->id),
      'fullName' => $this->when(($this->first_name && $this->last_name), trim($this->present()->fullname)),
      'activated' => $this->isActivated() ? 1 : 0,
      'email' => $this->when($this->email, $this->email),
      'lastLoginDate' => $this->when($this->last_login, $this->last_login),
      'smallImage' => isset($mainImage->value) ? 'assets/iprofiles/'.$this->id.'_smallThumb.jpg?'.$this->updated_at : 'modules/iprofile/img/default.jpg',
      'mediumImage' => isset($mainImage->value) ? 'assets/iprofiles/'.$this->id.'_mediumThumb.jpg?'.$this->updated_at : 'modules/iprofile/img/default.jpg',
      'mainImage' => isset($mainImage->value) ? $mainImage->value.'?'.$this->updated_at : 'modules/iprofile/img/default.jpg',
      'conversations' => ConversationTransformer::collection($this->whenLoaded('conversations')),
      'conversationsusers' => ConversationUserTransformer::collection($this->whenLoaded('conversationsusers')),
    ];
  }
}
