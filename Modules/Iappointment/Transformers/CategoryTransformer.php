<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iforms\Transformers\FormTransformer;

class CategoryTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title ?? '',
            'status' => $this->status ? '1' : '0',
            'slug' => $this->slug ?? '',
            'description' => $this->description ?? '',
            'parentId' => (int) $this->parent_id,
            'options' => $this->options,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'form' => new FormTransformer($this->form),
            'formId' => $this->form ? $this->form->id : null,
            'parent' => new CategoryTransformer($this->whenLoaded('parent')),
            'children' => CategoryTransformer::collection($this->whenLoaded('children')),
            'appointments' => AppointmentTransformer::collection($this->whenLoaded('appointments')),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';
                $data[$lang]['slug'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['slug'] : '';
                $data[$lang]['status'] = $this->hasTranslation($lang) ?
                  ($this->translate("$lang")['status'] ? '1' : '0') : '';
            }
        }

        return $data;
    }
}
