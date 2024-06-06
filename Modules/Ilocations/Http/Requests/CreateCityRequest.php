<?php

namespace Modules\Ilocations\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCityRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'name' => 'required',
          'code' => 'required',
          'province_id' => 'required',
          'country_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [

        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
