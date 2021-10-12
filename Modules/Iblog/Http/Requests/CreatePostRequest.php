<?php

namespace Modules\Iblog\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;
use Modules\Ihelpers\Rules\UniqueSlugRule;

class CreatePostRequest extends BaseFormRequest
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
            'summary'=>'required|min:2',
          'slug' => ["required",new UniqueSlugRule("iblog__post_translations"),"min:2"],
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
            'title.required' => trans('iblog::common.messages.title is required'),
            'title.min:2'=> trans('iblog::common.messages.title min 2 '),
            'summary.required'=> trans('iblog::common.messages.summary is required'),
            'summary.min:2'=> trans('iblog::common.messages.summary min 2 '),
            'description.required'=> trans('iblog::common.messages.description is required'),
            'description.min:2'=> trans('iblog::common.messages.description min 2 '),
          // slug
          'slug.required' => trans('iblog::common.messages.field required'),
          'slug.min:2' => trans('iblog::common.messages.min 2 characters'),

        ];
    }

}