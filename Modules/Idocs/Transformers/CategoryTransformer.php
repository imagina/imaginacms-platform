<?php

namespace Modules\Idocs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Isite\Transformers\RevisionTransformer;

class CategoryTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'slug' => $this->when($this->slug, $this->slug),
            'description' => $this->description ?? '',
            'private' => $this->when(isset($this->private), $this->private ? '1' : '0'),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
            'options' => $this->when($this->options, $this->options),
            'parent' => new CategoryTransformer($this->whenLoaded('parent')),
            'parentId' => $this->parent_id,
            'children' => CategoryTransformer::collection($this->whenLoaded('children')),
            'mediaFiles' => $this->mediaFiles(),
            'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
        ];

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['title'] : '';
                $data[$lang]['slug'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['slug'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['description'] ?? '' : '';
            }
        }

        return $data;
    }
}
