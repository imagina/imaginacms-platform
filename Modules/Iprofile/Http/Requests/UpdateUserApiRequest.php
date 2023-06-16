<?php

namespace Modules\Iprofile\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueRule;

class UpdateUserApiRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            //  'email' => ['required',new UniqueRule("users", $this->id, "id", trans("iprofile::userapis.messages.unavailableUserName"))],
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
