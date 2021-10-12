<?php


namespace Modules\Iforms\Transformers;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldTransformer extends JsonResource
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'type' => $this->when($this->type, (int)$this->type),
      'typeObject' => $this->when($this->type, $this->present()->type),
      'name' => $this->when($this->name, $this->name),
      'label' => $this->when($this->label, $this->label),
      'placeholder' => $this->when($this->placeholder, $this->placeholder),
      'description' => $this->when($this->description, $this->description),
      'required' => $this->required ? 1 : 0,
      'order' => $this->order,
      'width' => $this->width ?? 12,
      'prefix' => $this->when($this->prefix, $this->prefix),
      'suffix' => $this->when($this->suffix, $this->suffix),
      'blockId' => $this->block_id ?? '',
      'formId' => $this->when($this->form_id, $this->form_id),
      'selectable' => $this->when($this->selectable, $this->selectable),
      'options' => $this->options,
      'rules' => $this->rules,
      'form' => new FormTransformer($this->whenLoaded('form')),
      'block' => new BlockTransformer($this->whenLoaded('block')),
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

    $formType = $this->present()->type;

    $data['dynamicField'] = [
        'type' => in_array($formType['value'],['text', 'textarea', 'number', 'email', 'phone']) ? 'input' : ($formType['value'] === 'file' ? 'media' : $formType['value'] ),
        'name' => $this->name,
        'required' => $this->required ? true : false,
        'props' => [
            'type' => $formType['value'] === 'phone' ? 'tel' :($formType['value'] === 'file' ? 'media' : $formType['value'] ),
            'label' => $this->label,
        ]
    ];

    $formType['value'] === 'selectmultiple' ? $data['dynamicField']['props']['multiple'] = true : null;

    if(in_array($formType['value'], ['selectmultiple' ,'select', 'radio'])) {
        $options = json_decode($this->selectable) ?? [];
        $data['dynamicField']['props']['options'] = [];
        
        if(empty($options) && isset($this->options->fieldOptions) && !empty($this->options->fieldOptions)){
          $options = $this->options->fieldOptions;
        }

        foreach($options as $option){
            $data['dynamicField']['props']['options'][] = ["label" => $option->name ?? $option, "value" => $option->name ?? $option];
        }

    }
    return $data;
  }
}
