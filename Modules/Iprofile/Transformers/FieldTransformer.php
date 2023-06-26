<?php

namespace Modules\Iprofile\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldTransformer extends JsonResource
{
    public function toArray($request): array
    {
        if ($this->name == 'mainImage' && ! empty($this->value)) {
            $this->value .= '?'.uniqid();
        }

        return [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'value' => $this->when($this->value, $this->value),
            'type' => $this->when($this->type, $this->type),
            'user' => new UserTransformer($this->whenLoaded('user')),
        ];
    }
}
