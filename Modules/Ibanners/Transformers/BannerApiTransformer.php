<?php

namespace Modules\Ibanners\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerApiTransformer extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->when($this->title, $this->title),
            'caption' => $this->when($this->caption, $this->caption),
            'uri' => $this->when($this->uri, $this->uri),
            'url' => $this->when($this->url, $this->url),
            'active' => $this->when($this->active, $this->active),
            'type' => $this->when($this->type, $this->type),
            'order' => (int) $this->order,
            'positionId' => (int) $this->position_id,
            'customHtml' => $this->when($this->custom_html, $this->custom_html),
            'externalImageUrl' => $this->when($this->external_image_url, $this->external_image_url),
            'target' => $this->when($this->target, $this->target),
            'options' => $this->when($this->options, $this->options),
            'imageUrl' => $this->getImageUrl(),
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
                  $this->translate("$lang")['active'] == 1 ? 1 : 0 : 0;
                $data[$lang]['customHtml'] = $this->hasTranslation($lang) ?
                  $this->translate("$lang")['custom_html'] ? $this->translate("$lang")['custom_html'] : '' : '';
            }
        }

        return $data;
    }
}
