<?php

namespace Modules\Iauctions\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateBidRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'auction_id' => 'required',
            'description' => 'required',
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
            'auction_id.required' => trans('iauctions::common.messages.field required'),
            'description.required' => trans('iauctions::common.messages.field required'),
            'amount.required' => trans('iauctions::common.messages.field required')
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
