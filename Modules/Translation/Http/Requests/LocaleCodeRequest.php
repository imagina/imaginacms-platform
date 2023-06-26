<?php

namespace Modules\Translation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocaleCodeRequest extends FormRequest
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
            'order_by' => ['required', 'string'],
            'order' => ['required', 'string', 'in:asc,desc'],
            'search' => ['nullable', 'string', 'min:3'],
        ];
    }
}
