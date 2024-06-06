<?php

namespace Modules\Isite\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Ihelpers\Transformers\BaseApiTransformer;
use Illuminate\Support\Str;

class SettingTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
  
    $data = [
      'id' => $this->id,
      'name' => $this->name ?? '',
      'isTranslatable' => $this->isTranslatable == 0 ? false : true,
      'description' => $this->description ?? '',
      'value' => $this->isJson($this->plainValue) ? json_decode($this->plainValue) : $this->plainValue,
      'plainValue' => $this->isJson($this->plainValue) ? json_decode($this->plainValue) : $this->plainValue,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),

    ];
    
    if($this->isMedia()){
      $media = $this->files()->where('zone', $this->name)->first()->path_string ?? null;

      if ($media === null)
        $media = url('modules/isite/img/defaultLogo.jpg');
      $data["path"] = $media;
    }
  
    $filter = json_decode($request->filter);
  
    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();
    
      foreach ($languages as $lang => $value) {
        if($this->hasTranslation($lang))
        $data[$lang]['value'] = $this->translate("$lang")['value'];
      }
    }
    return $data;
  }

  function isJson($string) {
    return ((is_string($string) &&
    (is_object(json_decode($string)) ||
    is_array(json_decode($string))))) ? true : false;
  }
}
