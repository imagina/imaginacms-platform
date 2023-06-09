<?php

namespace Modules\Media\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Media\Validators\MaxFolderSizeRule;

class UploadMediaRequest extends FormRequest
{
    public function rules()
    {
        $maxFileSize = $this->getMaxFileSizeInKilobytes();

        return [
            'file' => [
                'required',
                new MaxFolderSizeRule($this->disk ?? null),
                mediaMimesAvailableRule(),
                "max:$maxFileSize",
            ],
        ];
    }

    public function messages()
    {
        $size = $this->getMaxFileSize();

        return [
            'file.max' => trans('media::media.file too large', ['size' => $size.' Mb']),
        ];
    }

    public function authorize()
    {
        return true;
    }

    private function getMaxFileSizeInKilobytes()
    {
        return $this->getMaxFileSize() * 1000;
    }

    private function getMaxFileSize()
    {
        return setting('media::maxFileSize', null, config('asgard.media.config.max-file-size'));
    }
}
