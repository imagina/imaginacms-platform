<?php

namespace Modules\Ievent\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAttendantRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          "event_id" => "required"
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
          'event_id.required' => trans('ievent::attendants.messages.eventIdRequired'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
