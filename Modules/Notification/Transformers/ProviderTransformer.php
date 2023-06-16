<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProviderTransformer extends JsonResource
{
    public function toArray($request)
    {
        //if($this->system_name == "firebase") dd($this);
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'systemName' => $this->when($this->system_name, $this->system_name),
            'status' => $this->status ? '1' : '0',
            'default' => $this->default ? true : false,
            'description' => $this->when($this->description, $this->description),
            'options' => $this->options,
            'fields' => $this->fields,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }
}
