<?php

namespace Modules\Iwhmcs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductGroupsToBitrix24Transformer extends JsonResource
{
  public function toArray($request)
  {
    return [
      'ID' => $this->when($this->bitrixId, $this->bitrixId),
      'CATALOG_ID' => '24',
      'SECTION_ID' => null,
      'NAME' => $this->name ?? '',
      'CODE' => $this->slug ?? '',
      'XML_ID' => $this->id,
    ];
  }
}
