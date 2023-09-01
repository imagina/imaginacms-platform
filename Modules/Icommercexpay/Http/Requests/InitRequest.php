<?php

namespace Modules\Icommercexpay\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class InitRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'orderID' => 'required',
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
            'orderID.required' => 'Order ID Requerido',

        ];
    }

    public function translationMessages()
    {
        return [
            'orderID.required' => 'Order ID Requerido',
        ];
    }
}
