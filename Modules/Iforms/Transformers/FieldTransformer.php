<?php


namespace Modules\Iforms\Transformers;
use Illuminate\Http\Resources\Json\Resource;

class FieldTransformer extends Resource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'type' => (int) $this->when($this->type, $this->type),
      'typeObject' => $this->when($this->type, $this->present()->type),
      'name' => $this->when($this->name, $this->name),
      'label' => $this->when($this->label, $this->label),
      'placeholder' => $this->when($this->placeholder, $this->placeholder),
      'description' => $this->when($this->description, $this->description),
      'required' => $this->required ? true : false,
      'order' => $this->order,
      'prefix' => $this->when($this->prefix, $this->prefix),
      'suffix' => $this->when($this->suffix, $this->suffix),
      'formId' => $this->when($this->form_id, $this->form_id),
      'selectable' => $this->when($this->selectable, $this->selectable),
      'form' => new FormTransformer($this->whenLoaded('form')),
    ];

    $filter = json_decode($request->filter);
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
      foreach ($languages as $lang => $value) {
        $data[$lang]['label'] = $this->hasTranslation($lang) ? $this->translate("$lang")['label'] : '';
        $data[$lang]['placeholder'] = $this->hasTranslation($lang) ? $this->translate("$lang")['placeholder'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ? $this->translate("$lang")['description'] : '';
      }
    }

    return $data;
  }
}
