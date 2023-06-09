<?php

namespace Modules\Requestable\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FormFieldTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'label' => $this->when($this->label, $this->label),
            'value' => $this->when($this->name, camelToSnake($this->name)), // Variables in the "fillables" are stored with notation snake_case
            //'id' => $this->when($this->id, $this->id),
            //'type' => $this->when($this->type, (int)$this->type),
            //'typeObject' => $this->when($this->type, $this->present()->type),
            //'formId' => $this->when($this->form_id, $this->form_id),
        ];

        return $data;
    }
}
