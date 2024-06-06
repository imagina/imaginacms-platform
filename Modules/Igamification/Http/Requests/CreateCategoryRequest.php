<?php

namespace Modules\Igamification\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
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
        return [];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('igamification::common.messages.field required'),
            'title.min:2' => trans('igamification::common.messages.min 2 characters')
        ];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
    
}
