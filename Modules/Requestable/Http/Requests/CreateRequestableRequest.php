<?php

namespace Modules\Requestable\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Requestable\Entities\Category;

class CreateRequestableRequest extends BaseFormRequest
{
    private $requestableRepository;

    public function rules()
    {
        $categories = Category::all();

        return [
            'type' => [
                'required',
                Rule::in($categories->pluck('type')->toArray()),
            ],
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
            'type.in' => 'The type is not in the default types defined',
            'type.required' => 'The type is required',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
