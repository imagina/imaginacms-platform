<?php

namespace Modules\Idocs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Iprofile\Transformers\UserTransformer;
use Modules\Isite\Transformers\RevisionTransformer;

class DocumentTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'key' => $this->when($this->key, $this->key),
            'url' => $this->when($this->url, $this->url),
            'publicUrl' => $this->when($this->public_url, $this->public_url),
            'downloaded' => $this->when($this->downloaded, $this->downloaded),
            'description' => $this->description ?? '',
            'size' => round($this->file->size / 1000000, 2),
            'mimeType' => $this->file->mimeType,
            'options' => $this->when($this->options, $this->options),
            'status' => $this->when(isset($this->status), $this->status ? '1' : '0'),
            'private' => $this->when(isset($this->private), $this->private ? '1' : '0'),
            'parentId' => $this->parent_id,
            'categoryId' => $this->category_id,
            'category' => new CategoryTransformer($this->whenLoaded('category')),
            'categories' => CategoryTransformer::collection($this->whenLoaded('categories')),
            'users' => UserTransformer::collection($this->whenLoaded('users')),
            'mediaFiles' => $this->mediaFiles(),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
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
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['description'] ?? '' : '';
            }
        }

        return $data;
    }
}
