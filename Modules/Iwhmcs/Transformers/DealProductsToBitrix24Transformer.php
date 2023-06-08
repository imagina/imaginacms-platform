<?php

namespace Modules\Iwhmcs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class DealProductsToBitrix24Transformer extends JsonResource
{
  public function toArray($request)
  {
    return [
      "PRODUCT_ID" => (strpos($this->type, 'Domain') !== false) ? 863/*Dominio Registrado*/ :
        ($this->bitrixProductId ?? 132/*hosting Linux Personal*/),
      "PRICE" => $this->amount,
      "QUANTITY" => 1
    ];
  }
}
