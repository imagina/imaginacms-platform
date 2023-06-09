<?php

namespace Modules\Iauctions\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateAuctionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'user_id' => 'required',
            'department_id' => 'required',
            'category_id' => 'required',
            'end_at' => 'after:start_at',
        ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required|min:2',
            'description' => 'required|min:2',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'user_id.required' => trans('iauctions::common.messages.field required'),
            'department_id.required' => trans('iauctions::common.messages.field required'),
            'category_id.required' => trans('iauctions::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('iauctions::common.messages.field required'),
            'title.min:2' => trans('iauctions::common.messages.min 2 characters'),
            'description.required' => trans('iauctions::common.messages.field required'),
            'description.min:2' => trans('iauctions::common.messages.min 2 characters'),
        ];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
