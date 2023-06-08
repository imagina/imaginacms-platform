<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iprofile\Transformers\UserTransformer;


class AttendantTransformer extends JsonResource
{
  public function toArray($request)
  {
    $mainImage = $this->user->fields()->where('name','mainImage')->first();
    $defaultImage = \URL::to('/modules/iprofile/img/default.jpg');

    $item = [
      'id' => $this->when($this->id, $this->id),
      'userId' => $this->when($this->user_id, $this->user_id),
      'user' => new UserTransformer($this->whenLoaded('user')),
      'eventId' => $this->when($this->event_id, $this->event_id),
      'fullName' => $this->user->present()->fullName,
      'firstName' => $this->user->first_name,
      'lastName' => $this->user->last_name,
      'mainImage' => isset($mainImage->value) ? $mainImage->value . '?' . now() : $defaultImage,
    ];


    return $item;
  }
}
