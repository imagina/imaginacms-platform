<?php

namespace Modules\Iredirect\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class RedirectRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'from' => 'required',
            'to' => 'required',
            'redirect_type' => 'required',
        ];
    }

    public function translationRules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
