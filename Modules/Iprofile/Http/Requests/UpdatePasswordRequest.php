<?php

namespace Modules\Iprofile\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdatePasswordRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
            'newPassword' => 'required|min:3',
            'newPasswordConfirmation' => 'required|same:newPassword'
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
            'email.required' => trans('iprofile::common.messages.field required'),
            'password.required' => trans('iprofile::common.messages.field required'),
            'newPassword.required' => trans('iprofile::common.messages.field required'),
            'newPasswordConfirmation.required' => trans('iprofile::common.messages.field required'),
            'newPasswordConfirmation.same' => trans('iprofile::common.messages.new password confirmed'),
        ];
    }

    public function translationMessages()
    {
        return [];
    }

    public function getValidator(){
        return $this->getValidatorInstance();
    }
}
