<?php

namespace Modules\Iauctions\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Iauctions\Rules\ValidatePath;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'system_name' => 'required',
            'bid_service' => new ValidatePath,
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required|min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'system_name.required' => trans('iauctions::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('iauctions::common.messages.field required'),
            'title.min:2' => trans('iauctions::common.messages.min 2 characters'),
        ];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
