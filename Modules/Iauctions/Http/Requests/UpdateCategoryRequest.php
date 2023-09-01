<?php

namespace Modules\Iauctions\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Iauctions\Rules\ValidatePath;

class UpdateCategoryRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'bid_service' => new ValidatePath,
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

    public function getValidator()
    {
        return $this->getValidatorInstance();
    }
}
