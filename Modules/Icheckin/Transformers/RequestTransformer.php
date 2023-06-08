<?php

namespace Modules\Icheckin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;

class RequestTransformer extends JsonResource
{
  public function toArray($request)
  {
    $item =  [
      'id' => $this->when($this->id, $this->id),
      'checkinAt' => $this->when($this->checkin_at, $this->checkin_at),
      'checkoutAt' => $this->when($this->checkout_at, $this->checkout_at),
      'requestId' => $this->when($this->request_id,$this->request_id),
      'shiftId' => $this->when($this->shift_id,$this->shift_id),
      'checkinBy' => new UserTransformer($this->whenLoaded('checkinBy')),
      'checkoutBy' => new UserTransformer($this->whenLoaded('checkoutBy')),
    ];

    return $item;
  }
}
