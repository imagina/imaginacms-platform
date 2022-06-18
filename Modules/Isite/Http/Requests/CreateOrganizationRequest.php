<?php

namespace Modules\Isite\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateOrganizationRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'title' => 'required|min:2',
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
