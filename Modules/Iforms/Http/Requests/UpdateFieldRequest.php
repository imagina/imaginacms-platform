<?php

namespace Modules\Iforms\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Media\Validators\AvailableExtensionsRule;

class UpdateFieldRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'options.availableExtensions' => [
                new AvailableExtensionsRule(),
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
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
