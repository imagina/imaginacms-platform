<?php

namespace Modules\Ilocations\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateProvinceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'iso_2' => 'required',
            'country_id' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
            'name' => 'required|min:2',
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
