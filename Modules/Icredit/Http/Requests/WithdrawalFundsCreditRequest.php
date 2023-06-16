<?php

namespace Modules\Icredit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class WithdrawalFundsCreditRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required',
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
            'amount.required' => trans('icredit::common.messages.field required'),
        ];
    }

    public function translationMessages()
    {
        return [
            'amount.required' => trans('icredit::common.messages.field required'),
        ];
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
