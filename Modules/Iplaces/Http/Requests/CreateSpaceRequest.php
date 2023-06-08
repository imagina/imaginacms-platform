<?php

namespace Modules\Iplaces\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreateSpaceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [
            'title'=>'required|min:2',
            'description'=>'required|min:2',
            'slug'=>'required|min:2',
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
            'title.required' => trans('iplaces::places.messages.name is required'),
            'title.min'=>trans('iplaces::places.messages.name is min 2'),
            'description.required' => trans('iplaces::places.messages.description is required'),
            'description.min'=>trans('iplaces::places.messages.description is min 2'),
            'slug.required' => trans('iplaces::places.messages.slug is required'),
            'slug.min'=>trans('iplaces::places.messages.slug is min 2'),
        ];
    }
}
