<?php

namespace Modules\Icredit\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class CreditTransformer extends CrudResource
{
	
	/**
	  * Method to merge values with response
	  *
	  * @return array
	  */
	public function modelAttributes($request)
	{
		
		$filter = json_decode($request->filter);

		
		if(isset($filter) && isset($filter->amountAvailable)){
			return [];
		}else{
			return [
		      'statusName' => $this->statusName,
		    ]; 	
		}
		   
	}
    
}