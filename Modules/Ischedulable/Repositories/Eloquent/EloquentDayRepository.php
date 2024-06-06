<?php

namespace Modules\Ischedulable\Repositories\Eloquent;

use Modules\Ischedulable\Repositories\DayRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentDayRepository extends EloquentCrudRepository implements DayRepository
{

	/**
   	* Filter name to replace
   	* @var array
   	*/
  	protected $replaceFilters = [];

  	/**
   	* Filter query
   	*
   	* @param $query
   	* @param $filter
   	* @return mixed
   	*/
  	public function filterQuery($query, $filter)
  	{

    /**
     * Note: Add filter name to replaceFilters attribute to replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

    	//Response
    	return $query;
  	}

}
