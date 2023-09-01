<?php

namespace Modules\Requestable\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAutomationRuleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'run_type' => 'required',
            'to' => 'required',
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
            'name.required' => trans('requestable::common.messages.field required'),
            'run_type.required' => trans('requestable::common.messages.field required'),
            'to.required' => trans('requestable::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
