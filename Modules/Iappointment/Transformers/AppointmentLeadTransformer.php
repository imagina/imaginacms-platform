<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentLeadTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name ?? '',
            'value' => $this->value ?? '',
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'appointment' => new AppointmentTransformer($this->whenLoaded('appointment')),
        ];

        return $data;
    }
}
