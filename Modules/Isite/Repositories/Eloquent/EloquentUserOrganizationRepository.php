<?php

namespace Modules\Isite\Repositories\Eloquent;

use Modules\Isite\Repositories\UserOrganizationRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentUserOrganizationRepository extends EloquentCrudRepository implements UserOrganizationRepository
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
