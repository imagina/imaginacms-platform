<?php

namespace Modules\Slider\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;

class SlideApiTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->id,
      'title' => $this->title,
      'caption' => $this->caption,
      'uri' => $this->uri,
      'url' => $this->url,
      'active' => $this->active ? 1 : 0,
      'type' => $this->type,
      'position' => (int)$this->position,
      'sliderId' => (int)$this->slider_id,
      'customHtml' => $this->custom_html ? $this->custom_html : '',
      'externalImageUrl' => $this->external_image_url,
      'target' => $this->target,
      'options' => $this->when($this->options, $this->options),
      'imageUrl' => $this->getImageUrl()
    ];

    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['caption'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['caption'] ?? '' : '';
        $data[$lang]['uri'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['uri'] : '';
        $data[$lang]['url'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['url'] : '';
        $data[$lang]['active'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['active'] ? 1 : 0 : '';
        $data[$lang]['customHtml'] = $this->hasTranslation($lang) ?
          ($this->translate("$lang")['custom_html'] ? $this->translate("$lang")['custom_html'] : '') : '';
      }
    }

    return $data;
  }
}
