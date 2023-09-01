<?php

namespace Modules\Iappointment\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Isite\Http\Controllers\Api\ConfigsApiController;

class ProviderTransformer extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            'id' => $this->when($this->id, $this->id),
            'title' => $this->when($this->title, $this->title),
            'description' => $this->when($this->description, $this->description),
            'name' => $this->when($this->name, $this->name),
            'status' => $this->status ? 1 : 0,
            'init' => $this->when(isset($this->options), $this->options->init),
            'options' => $this->when($this->options, $this->options),
            'mediaFiles' => $this->mediaFiles(),
            'createdAt' => $this->when($this->created_at, $this->created_at),
            'updatedAt' => $this->when($this->updated_at, $this->updated_at),
        ];

        // Add Crud Fields from Provider
        if (isset($this->name) && ! empty($this->name)) {
            $config = ucfirst($data['name']).'.crud-fields.formFields';

            $fieldsController = new ConfigsApiController();
            $data['crudFields'] = $fieldsController->validateResponseApi($fieldsController->index(new Request([
                'filter' => json_encode(['configName' => $config]),
            ])));
        }

        $filter = json_decode($request->filter);

        // Return data with available translations
        if (isset($filter->allTranslations) && $filter->allTranslations) {
            // Get langs avaliables
            $languages = \LaravelLocalization::getSupportedLocales();

            foreach ($languages as $lang => $value) {
                $data[$lang]['title'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['title'] : '';
                $data[$lang]['description'] = $this->hasTranslation($lang) ?
                    $this->translate("$lang")['description'] ?? '' : '';
            }
        }

        return $data;
    }
}
