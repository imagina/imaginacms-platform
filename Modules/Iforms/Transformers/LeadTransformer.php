<?php

namespace Modules\Iforms\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Isite\Transformers\RevisionTransformer;
use Modules\Media\Transformers\NewTransformers\MediaTransformer;

class LeadTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'formId' => $this->when($this->form_id, $this->form_id),
            'assignedToId' => $this->when($this->assigned_to_id, $this->assigned_to_id),
            'values' => $this->when($this->values, $this->values),
            'valuesImploded' => "ID: $this->id, ".Str::limit(implode(', ', $this->values), 150),
            'form' => new FormTransformer($this->whenLoaded('form')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'assignedTo' => new UserTransformer($this->whenLoaded('assignedTo')),
            'files' => MediaTransformer::collection($this->whenLoaded('files')),
            'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
        ];

        $form = $this->form;
        $fields = $form->fields;

        foreach ($fields as $field) {
            if ($field->type == 12) { //FILE
                $data['values'][$field->name] = url($data['values'][$field->name] ?? '');
            }
        }

        return $data;
    }
}
