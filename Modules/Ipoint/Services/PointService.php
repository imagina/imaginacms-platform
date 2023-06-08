<?php

namespace Modules\Ipoint\Services;

use Modules\Ipoint\Repositories\PointRepository;

class PointService
{

	private $point;


	public function __construct(
		PointRepository $point
	){
		$this->point = $point;
	}

	/**
    * 
    * @param 
    * @return 
    */
	public function create($model,$data){

		//\Log::info('Ipoint: Point Service - Data: '.json_encode($data));
     	try {

     		 // Data to Save
          	$data = [
            	'user_id' => $data["user_id"] ?? $model->user_id ?? \Auth::id(),
            	'pointable_id' => $model->id,
            	'pointable_type' => get_class($model),
            	'description' => $data['description'] ?? null,
            	'points' => $data['points'] ?? 0
          	];

     		$point = $this->point->create($data);

			return $point;

     	} catch (\Exception $e) {

     		\Log::info('Ipoint: Point Service - Create - ERROR: '.$e->getMessage().' Code:'.$e->getErrorCode());
        	\Log::error("error: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . $e->getTraceAsString());


      	}

	}


}