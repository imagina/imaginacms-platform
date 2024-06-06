<?php

namespace Modules\Ilocations\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProvinceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'name' => 'required',
          'iso_2' => 'required',
          'country_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [];
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
