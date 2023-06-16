<?php

namespace Modules\Ibooking\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ibooking\Repositories\ServiceResourceRepository;

class EloquentServiceResourceRepository extends EloquentBaseRepository implements ServiceResourceRepository
{
    /**
     * Filter name to replace
     *
     * @var array
     */
    protected $replaceFilters = [];

    /**
     * Filter query
     *
     * @return mixed
     */
    public function filterQuery($query, $filter, $params)
    {
        /**
         * Note: Add filter name to replaceFilters attribute to replace it
         *
         * Example filter Query
         * if (isset($filter->status)) $query->where('status', $filter->status);
         */

        //Response
        return $query;
    }
}
