<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Modules\User\Transformers\UserTransformer;

class SettingTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {


    return [
      'id' => $this->when($this->id,$this->id),
      'name' => $this->when($this->name,$this->name),
      'value' => $this->when(isset($this->value),$this->value),
      'type' => $this->when($this->type,$this->type),
      'relatedId' => $this->when($this->related_id,$this->related_id),
      'entityName' => $this->when($this->entity_name,$this->entity_name)
    ];
  }

}
