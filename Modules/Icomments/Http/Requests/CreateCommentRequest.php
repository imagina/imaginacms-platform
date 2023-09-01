<?php

namespace Modules\Icomments\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateCommentRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'comment' => 'required',
            'commentable_type' => 'required',
            'commentable_id' => 'required',
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
            'comment.required' => trans('requestable::common.messages.field required'),
            'commentable_type.required' => trans('requestable::common.messages.field required'),
            'commentable_id.required' => trans('requestable::common.messages.field required'),
        ];
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
