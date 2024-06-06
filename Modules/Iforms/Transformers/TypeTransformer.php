<?php


namespace Modules\Iforms\Transformers;
use Illuminate\Http\Resources\Json\Resource;

class TypeTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
    ];

    return $data;
  }
}
