<?php


namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Iprofile\Transformers\UserTransformer;

class ProviderTransformer extends Resource
{
  public function toArray($request)
  {
 
    $data = [
      'id' => $this->when($this->id, $this->id),
      'name' => $this->when($this->name, $this->name),
      'systemName' => $this->when($this->system_name, $this->system_name),
      'status' => $this->status ? '1' : '0',
      'description' => $this->when($this->description, $this->description),
      'options' => $this->options,
      'fields' => $this->fields,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];
    
    return $data;
  }
}
