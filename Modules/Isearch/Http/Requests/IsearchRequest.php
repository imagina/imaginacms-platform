<?php

namespace Modules\Isearch\Http\Requests;

use App\Http\Requests\Request;

class IsearchRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => 'required|min:2',
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
            'search.required' => trans('isearch::common.messages.search is required'),
            'search.min:2' => trans('isearch::common.messages.search min 2 '),
        ];
    }
}
