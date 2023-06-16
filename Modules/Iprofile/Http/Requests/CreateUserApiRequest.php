<?php

namespace Modules\Iprofile\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueRule;
use Modules\Iprofile\Rules\FieldsRule;

class CreateUserApiRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            // 'first_name' => 'required',
            // 'last_name' => 'required',
            'email' => ['required', new UniqueRule('users', null, null, trans('iprofile::userapis.messages.unavailableUserName'))],
            'password' => 'required',
            'fields' => new FieldsRule(),
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
            // First Name
            'first_name.required' => trans('iprofile::userapis.messages.firstNameRequired'),

            // Last Name
            'last_name.required' => trans('iprofile::userapis.messages.lastNameRequired'),

            // email
            'email.required' => trans('iprofile::userapis.messages.emailRequired'),

            // password
            'password.required' => trans('iprofile::userapis.messages.passwordRequired'),

        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
