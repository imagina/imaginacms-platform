<?php

namespace Modules\Iplan\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateLimitRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'entity' => 'required',
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
