<?php

namespace Modules\Requestable\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;

class CreateStatusRequest extends BaseFormRequest
{
    public function rules()
    {
        $categoryService = app("Modules\Requestable\Services\CategoryService");

        return [
            'category_id' => 'required',
            'value' => Rule::requiredIf($categoryService->isInternal($this->category_id)),
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
            'category_id.required' => trans('requestable::common.messages.field required'),
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
