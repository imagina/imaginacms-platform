<?php


namespace Modules\Iforms\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Isite\Transformers\RevisionTransformer;

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
      'revisions' => RevisionTransformer::collection($this->whenLoaded('revisions')),
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

    //simplifying the type value variable
    $fieldType = $this->present()->type["value"] ?? "";

    /**
     * creating the dynamic field to the iadmin
     * values correlations
     * type ($fieldType):
     *    ['text', 'textarea', 'number', 'email', 'phone'] => "input"
     *    'file' => 'media'
     *    'selectmultiple' => 'select'
     *    default => $fieldType
     *
     * name ($fieldType):
     *    'file' => 'mediasSingle'
     *    default => $this->name // field name
     *
     * value ($fieldType): // default value
     *    ['selectmultiple','radio'] => []
     *    ['checkbox'] => false
     *
     * props.type ($fieldType):
     *    'phone' => 'tel'
     *    'file' => 'media'
     *    default => $fieldType
     *
     * props.multiple ($fieldType):
     *    'selectmultiple' => true
     *    default => false
     */
    $data['dynamicField'] = [
      'type' => in_array($fieldType, ['text', 'textarea', 'number', 'email', 'phone']) ? 'input' :
        ($fieldType === 'file' ? 'media' :
          ($fieldType == 'selectmultiple' ? 'select' : $fieldType)
        ),
      'name' => $fieldType === 'file' ? "mediasSingle" : $this->name,
      'required' => $this->required ? true : false,
      "value" => in_array($fieldType, ['selectmultiple', 'radio']) ? [] :
        (in_array($fieldType, ['checkbox']) ? false : ""),
      'colClass' => "col-12 col-sm-" . ($field->width ?? '12'),
      'props' => [
        'label' => $this->label,
        'entity' => $this->options["entity"] ?? "",
        'multiple' => $fieldType === 'selectmultiple' ? true : false
      ]
    ];

    //props type
    $availableTypes = ["number", "email"];
    (in_array($fieldType, $availableTypes)) ? $data['dynamicField']['props']['type'] = $fieldType : false;

    //Options for ['selectmultiple', 'select', 'radio', 'treeSelect'] field types
    if (in_array($fieldType, ['selectmultiple', 'select', 'radio', 'treeSelect'])) {

      // getting the options from the selectable attribute for old sites created with the Iform before Dec, 2021
      $options = json_decode($this->selectable) ?? [];

      //if already exist the loadOptions saved in DB
      if (isset($this->options["loadOptions"]) && !empty($this->options["loadOptions"])) {
        $data['dynamicField']['loadOptions'] = $this->options["loadOptions"];
      }

      //getting the fieldOptions saved in DB for old sites created with the Iform before Dec, 2021
      if (empty($options) && isset($this->options["fieldOptions"]) && !empty($this->options["fieldOptions"])) {

        $data['dynamicField']['props']['options'] = [];

        $options = $this->options["fieldOptions"];
      }

      //Added options in the format label: value, expected for the frontend standard
      foreach ($options as $option) {
        $data['dynamicField']['props']['options'][] = ["label" => $option->name ?? $option, "value" => $option->name ?? $option];
      }

    }

    //Add options for texare
    if ($fieldType == "textarea") {
      $data['dynamicField']['props']['type'] = "textarea";
      $data['dynamicField']['props']['rows'] = 3;
    }

    return $data;
  }
}
