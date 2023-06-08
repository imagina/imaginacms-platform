<?php

namespace Modules\Iplaces\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Iplaces\Events\CategoryWasCreated;
use Modules\Isite\Transformers\RevisionTransformer;

class CategoryTransformer extends JsonResource
{

  public function toArray($request)
  {

    $data = [
      'id' => $this->when(isset($this->id), $this->id),
      'title' => $this->when(isset($this->title), $this->title),
      'slug' => $this->when(isset($this->slug), $this->slug),
      'description' => $this->when(isset($this->description), $this->description),
      'status' => $this->status ? 1 : null,
      'parentId' => $this->when(isset($this->parent_id), $this->parent_id),
      'metaTitle' => $this->when($this->meta_title, $this->meta_title),
      'options' => $this->when($this->options, $this->options),
      'metaDescription' => $this->when($this->meta_description, $this->meta_description),
      'metaKeywords' => $this->when($this->meta_keywords, $this->meta_keywords),
      'mainImage' => $this->main_image,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_ay, $this->updated_ay),
      'parent' => new CategoryTransformer($this->whenLoaded('parent')),
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
        $data[$lang]['slug'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['slug'] : '';
        $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_title'] : '';
        $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['meta_description'] : '';
      }
    }
    return $data;


  }


}
