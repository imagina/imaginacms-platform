<?php

namespace Modules\Icustom\Http\Requests;

use App\Http\Requests\Request;

class IcustomRequest extends \Modules\Bcrud\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            //'title' => 'required|min:2|max:255',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
