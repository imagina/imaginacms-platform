<?php

namespace Modules\Icurrency\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Icurrency\Support\Facades\Currency;

class CurrencyTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'code' => $this->when($this->code, $this->code),
      'symbolLeft' => $this->when($this->symbol_left, $this->symbol_left),
      'symbolRight' => $this->when($this->symbol_right, $this->symbol_right),
      'decimalPlace' => $this->when($this->decimal_place, $this->decimal_place),
      'defaultCurrency' => $this->default_currency ? true : false,
      'value' => $this->when($this->value, $this->value),
      'status' => $this->when($this->status, $this->status),
      'options' => $this->when($this->options, $this->options),
      'createdAt ' => $this->when($this->created_at, $this->created_at),
      'updatedAt ' => $this->when($this->updated_at, $this->updated_at),
    ];
    return $data;
  }
}
