<?php

namespace Modules\Isite\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateRecommendationRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
          'name' => 'required',
        ];
    }

    public function translationRules()
    {
        return [
          'title' => 'required',
          'description' => 'required',
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
