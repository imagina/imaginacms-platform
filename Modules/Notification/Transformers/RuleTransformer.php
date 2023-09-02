<?php

namespace Modules\Notification\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RuleTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'name' => $this->when($this->name, $this->name),
            'entityName' => $this->when($this->entity_name, $this->entity_name),
            'eventPath' => $this->when($this->event_path, $this->event_path),
            'conditions' => $this->when($this->conditions, $this->conditions),
            'settings' => $this->when($this->settings, $this->settings),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        return $data;
    }
}
