<?php

namespace Modules\Page\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PageApiTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' =>$this->when($this->id, $this->id),
            'isHome' => $this->when($this->is_home, $this->is_home),
            'template' => $this->when($this->template, $this->template),
            'recordType' => $this->when($this->record_type, $this->record_type),
            'type' => $this->when($this->type, $this->type),
            'system_name' => $this->when($this->system_name, $this->system_name),
            'internal' => $this->when($this->internal, $this->internal),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'title' => $this->when($this->title, $this->title),
            'slug' => $this->when($this->slug, $this->slug),
            'options' => $this->when($this->options, $this->options),
            'status' => $this->when(isset($this->status), $this->status ? 1 : 0),
            'urls' => [
                'deleteUrl' => route('api.page.page.destroy', $this->resource->id),
            ],
            'mediaFiles' => $this->type != 'cms' ? $this->mediaFiles() : []
        ];
  
      foreach ($this->tags as $tag) {
        $data['tags'][] = $tag->name;
      }
      
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
          $data[$lang]['status'] = $this->hasTranslation($lang) ?
            isset($this->translate("$lang")['status']) ? $this->translate("$lang")['status'] ? "1" : "0" : '' : '';
          $data[$lang]['body'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['body'] ?? '' : '';
          $data[$lang]['metaTitle'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['meta_title'] ?? '' : '';
          $data[$lang]['metaDescription'] = $this->hasTranslation($lang) ?
            $this->translate("$lang")['meta_description'] ?? '' : '';

        }
      }


      return $data;
    }
}
