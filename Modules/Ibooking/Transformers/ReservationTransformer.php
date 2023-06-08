<?php

namespace Modules\Ibooking\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

//use Modules\Imeeting\Traits\MeetingableTransformer;

class ReservationTransformer extends CrudResource
{

	//use MeetingableTransformer;

	public function modelAttributes($request)
	{

		// I do not remember if in the end it was used but it is left commented for the moment
		/*
		if(setting('ibooking::createExternalMeeting'))
			$data = $this->getDataMeetings();
		return $data;
		*/
		return [
      		'statusName' => $this->statusName
    	];

	}
    
}
