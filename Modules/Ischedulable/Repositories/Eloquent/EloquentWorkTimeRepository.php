<?php

namespace Modules\Ischedulable\Repositories\Eloquent;

use Modules\Ischedulable\Repositories\WorkTimeRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentWorkTimeRepository extends EloquentCrudRepository implements WorkTimeRepository
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
     * @param $params
   	* @return mixed
   	*/
  	public function filterQuery($query, $filter, $params)
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
