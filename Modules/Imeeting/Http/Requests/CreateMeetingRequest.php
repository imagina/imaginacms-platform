<?php

namespace Modules\Imeeting\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateMeetingRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'meetingAttr' => 'required|array',
            'entityAttr' => 'required|array',
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
        return [
            'meetingAttr.required' => 'meetingAttr - Array Requerido',
            'entityAttr.required' => 'entityAttr - Array Requerido',
        ];
    }

    public function translationMessages()
    {
        return [
            'meetingAttr.required' => 'meetingAttr - Array Requerido',
            'entityAttr.required' => 'entityAttr - Array Requerido',
        ];
    }
}
