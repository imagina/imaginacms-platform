<?php

namespace Modules\Ipay\Http\Requests;

use App\Http\Requests\Request;

class IpayRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|min:1|max:255',
            'merchantid' => 'numeric',
            'accountid' => 'numeric',
            'apikey' => 'required|min:1|max:255',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
