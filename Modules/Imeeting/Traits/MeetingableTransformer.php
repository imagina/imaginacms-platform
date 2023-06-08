<?php

namespace Modules\Imeeting\Traits;

trait MeetingableTransformer
{


	/**
   	* Method to merge values with response
   	*
   	* @return array
   	*/
  
	public function getDataMeetings()
	{
		
		$data = [
            'meetings' => $this->when($this->meetings, $this->meetings)
        ];

        return $data;
        
	}

  	


}