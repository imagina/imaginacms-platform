<?php


namespace Modules\Iforms\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class BlockTransformer extends JsonResource
{

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'name' => $this->when($this->name, $this->name),
      'description' => $this->when($this->description, $this->description),
      'options' => $this->when($this->options, $this->options),
      'sortOrder' => $this->when($this->sort_order, $this->sort_order),
      'fields' => FieldTransformer::collection($this->whenLoaded('fields')),
      'form' => new FormTransformer($this->whenLoaded('form')),
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
    ];

    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ? $this->translate("$lang")['title'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ? $this->translate("$lang")['description'] : '';
      }
    }

    return $data;
  }
}
