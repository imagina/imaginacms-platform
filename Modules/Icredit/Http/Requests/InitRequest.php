<?php

namespace Modules\Icredit\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class InitRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'orderId' => 'required'
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
            'orderId.required' => "Order Id Requerido", 
            
        ];
    }

    public function translationMessages()
    {
        return [
            'orderId.required' => "Order Id Requerido", 
        ];
    }
}
