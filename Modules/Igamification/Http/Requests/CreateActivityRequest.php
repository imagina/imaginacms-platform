<?php

namespace Modules\Igamification\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateActivityRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'system_name' => 'required',
            //'url' => 'required|min:5'
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
            'system_name.required' => trans('igamification::common.messages.field required'),
            //'url.required' => trans('igamification::common.messages.field required')
        ];
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
