<?php

namespace Modules\Iauctions\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusBidTransformer extends JsonResource
{
  

  public function toArray($request)
  {

    $data = [
      'value' => $this->when($this->value, $this->value),
      'name' => $this->when($this->name,$this->name)
    ];
    
    return $data;
  }

}
