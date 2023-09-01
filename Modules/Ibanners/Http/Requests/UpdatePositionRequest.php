<?php

namespace Modules\Ibanners\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePositionRequest extends FormRequest
{
    public function rules()
    {
        $position = $this->route()->parameter('position');

        return [
            'name' => 'required',
            'primary' => "unique:ibanners__positions,primary,{$position->id}",
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => trans('ibanners::validation.name is required'),
            'system_name.required' => trans('ibanners::validation.system name is required'),
        ];
    }
}
