<?php

namespace Modules\Icredit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class CreateCreditRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {

        return [
            'description' => 'required|min:2',
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

            // description
            'description.required' => trans('icredit::common.messages.field required'),
            'description.min:2' => trans('icredit::common.messages.min 2 characters'),
        ];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}