<?php

namespace Modules\Ibooking\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Ibooking\Repositories\CategoryRepository;

class EloquentCategoryRepository extends EloquentCrudRepository implements CategoryRepository
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
        if (isset($filter->hasServices)) {
            $query->has('services');
        }

        //Response
        return $query;
    }
}
