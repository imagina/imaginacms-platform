<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\Iplaces\Transformers\PlaceTransformer;
use Modules\Iplaces\Transformers\RouteTransformer;
use Modules\Iprofile\Transformers\DepartmentTransformer;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Iteam\Transformers\SimpleTeamTransformer;
use Modules\Iteam\Transformers\TeamTransformer;

class EventSimpleTransformer extends JsonResource
{
  public function toArray($request)
  {

    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'date' => substr($this->date, 0, 10). ' ' . $this->hour,
      'hour' => $this->when($this->hour, $this->hour),
      'options' => $this->when($this->options, $this->options),
      'isPublic' => $this->is_public."",
      'description' => $this->description,
      'status' => $this->status,
      'statusName' => $this->status_name,
      'createdAt' => $this->when($this->created_at, $this->created_at)

    ];


    return $data;
  }
}
