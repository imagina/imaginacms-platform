<?php

namespace Modules\Iprofile\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Iprofile\Rules\FieldsRule;

class CreateUserApiRequest extends BaseFormRequest
{
    public function rules()
    {
      return [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required',
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
        'first_name.required' => trans('iprofile::common.messages.field required'),
        
        // Last Name
        'last_name.required' => trans('iprofile::common.messages.field required'),
        
        // email
        'email.required' => trans('iprofile::common.messages.field required'),
  
        // password
        'password.required' => trans('iprofile::common.messages.field required'),

      ];
    }

    public function translationMessages()
    {
        return [];
    }
}
