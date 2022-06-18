<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Media\Validators\AlphaDashWithSpaces;

class CreateFolderRequest extends FormRequest
{
    public function rules()
    {
        $parentId = $this->get('parent_id');
        $tenant = tenant() ?? null;
 
        return [
            'name' => [
                new AlphaDashWithSpaces(),
                'required',
                Rule::unique('media__files', 'filename')->where(function ($query) use ($parentId, $tenant) {
                    $query->where('is_folder', 1)->where('folder_id', $parentId)->where("id","!=",$this->id);
                    if(isset($tenant->id))
                      return $query->where('organization_id', $tenant->id);
                    else
                      return $query;
                    
                }),
            ],
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
          "name.unique" => trans("media::messages.folderNameUnique")
        ];
    }
}
