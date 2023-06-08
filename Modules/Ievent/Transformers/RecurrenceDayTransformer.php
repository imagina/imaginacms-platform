<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Transformers\UserTransformer;

class RecurrenceDayTransformer extends JsonResource
{
  public function toArray($request)
  {

    return [
      'id' => $this->when($this->id, $this->id),
      'days' => $this->when($this->days, $this->days),
      'hour' => $this->when($this->hour, $this->hour)

    ];

  }
}
