<?php

namespace Modules\Translation\Transformers;

use App;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationApiTransformer extends JsonResource
{
    public $preserveKeys = true;

    public function toArray($request)
    {
        //Validate data
        if (is_null($this->resource)) {
            return [];
        }
        //Get data
        $data = is_array($this->resource) ? $this->resource : $this->resource->toArray();
        //also set key as Id
        $data['id'] = $data['key'];
        //Set value to first lavel
        if (isset($data[App::getLocale()])) {
            $data['value'] = $data[App::getLocale()]['value'];
        } else {
            $languages = \LaravelLocalization::getSupportedLocales();
            foreach ($languages as $lang => $value) {
                if (isset($data[$lang]['value'])) {
                    $data['value'] = $data[$lang]['value'];
                }
            }
        }

        //Response
        return $data;
    }
}
