<?php

namespace Modules\Requestable\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRuleRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'title' => 'required',
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
        return [
            'title.required' => trans('requestable::common.messages.field required'),
        ];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
