<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentStatusTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title ?? '',
            'parentId' => (int) $this->parent_id,
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'parent' => new AppointmentStatusTransformer($this->whenLoaded('parent')),
            'children' => AppointmentStatusTransformer::collection($this->whenLoaded('children')),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
            }
        }

        return $data;
    }
}
