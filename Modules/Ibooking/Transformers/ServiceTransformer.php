<?php

namespace Modules\Ibooking\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

use Modules\Iforms\Transformers\FormTransformer;
use Modules\Ibooking\Entities\Service;

class ServiceTransformer extends CrudResource
{

	public function modelAttributes($request)
	{

		$service = Service::find($this->id);

		return [
			'form' => new FormTransformer($service->form),
      		'formId' => $service->form ? $service->form->id : null
		];

	}
    
}
