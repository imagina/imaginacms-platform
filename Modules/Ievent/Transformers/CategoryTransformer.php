<?php

namespace Modules\Ievent\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->title ?? '',
            'slug' => $this->slug ?? '',
            'status' => $this->status,
            'description' => $this->description ?? '',
            'url' => $this->when($this->url, $this->url),
            'parentId' => (string) $this->parent_id,
            'placeCategoryId' => (int) $this->place_category_id,
            'placeCategory' => new \Modules\Iplaces\Transformers\CategoryTransformer($this->whenLoaded('placeCategory')),
            'options' => $this->when($this->options, $this->options),
            'parent' => new CategoryTransformer($this->whenLoaded('parent')),
            'children' => CategoryTransformer::collection($this->whenLoaded('children')),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'mediaFiles' => $this->mediaFiles(),
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
            }
        }

        return $data;
    }
}
