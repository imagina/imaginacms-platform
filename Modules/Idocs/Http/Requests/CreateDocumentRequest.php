<?php

namespace Modules\Idocs\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateDocumentRequest extends BaseFormRequest
{
    public function rules()
    {
      return [
        'category_id' => 'required',
      ];
    }

    public function translationRules()
    {
        return [
            'title' => 'required|min:2',
            'description' => 'required|min:2',
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
        return [
            'title.required' => trans('idocs::common.messages.title is required'),
            'title.min:2'=> trans('idocs::common.messages.title min 2 '),
            'description.required' => trans('idocs::common.messages.description is required'),
            'description.min:2'=> trans('idocs::common.messages.description min 2 '),
        ];
    }
}
