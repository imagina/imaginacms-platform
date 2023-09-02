<?php

namespace Modules\Iforms\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class FormTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'systemName' => $this->when($this->system_name, $this->system_name),
            'submitText' => $this->when($this->submit_text, $this->submit_text),
            'successText' => $this->when($this->success_text, $this->success_text),
            'active' => $this->when($this->active, $this->active),
            'destinationEmail' => $this->when($this->destination_email, $this->destination_email),
            'userId' => $this->when($this->user_id, $this->user_id),
            'options' => $this->when($this->options, $this->options),
            'formType' => $this->form_type ?? 0,
            'fields' => FieldTransformer::collection($this->whenLoaded('fields')),
            'blocks' => BlockTransformer::collection($this->whenLoaded('blocks')),
            'leads' => LeadTransformer::collection($this->whenLoaded('leads')),
            'user' => new UserTransformer($this->whenLoaded('user')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'url' => $this->url ?? '#',
            'embed' => $this->embed ?? '',
            'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
        ];

        $filter = json_decode($request->filter);
        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();
            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
                $data[$lang]['submitText'] = $this->hasTranslation($lang) ? $this->translate("$lang")['submit_text'] : '';
                $data[$lang]['successText'] = $this->hasTranslation($lang) ? $this->translate("$lang")['success_text'] : '';
            }
        }

        return $data;
    }
}
