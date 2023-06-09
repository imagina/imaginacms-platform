<?php

namespace Modules\Ischedulable\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateScheduleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'entity_id' => 'required',
            'entity_type' => 'required',
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
