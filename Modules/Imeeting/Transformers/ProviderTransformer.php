<?php

namespace Modules\Imeeting\Transformers;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Transformers\CrudResource;
use Modules\Isite\Http\Controllers\Api\ConfigsApiController;

class ProviderTransformer extends CrudResource
{
    /**
     * Method to merge values with response
     *
     * @return array
     */
    public function modelAttributes($request): array
    {
        $data = null;

        if (isset($this->name) && ! empty($this->name)) {
            $config = 'imeeting.crud-fields.'.$this->name.'.formFields';
            $fieldsController = new ConfigsApiController();
            $data['crudFields'] = $fieldsController->validateResponseApi($fieldsController->index(new Request([
                'filter' => json_encode(['configName' => $config]),
            ])));
        }

        return $data;
    }
}
