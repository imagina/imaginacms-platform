<?php

namespace Modules\Requestable\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'type' => 'required|min:5|unique:requestable__categories'
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
            'type.required' => trans('requestable::common.messages.field required'),
            'type.unique' => trans('requestable::common.messages.field unique',['field'=>'TIPO']),
        ];
    }

    public function translationMessages()
    {
        return [];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }

}
