<?php

namespace Modules\Ibooking\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Ibooking\Repositories\ReservationRepository;

class EloquentReservationRepository extends EloquentCrudRepository implements ReservationRepository
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
        // if has permission index-all
        /*
        $indexAllPermission = $params->permissions['ibooking.reservations.index-all'] ?? false; // show orders of others

        if(!$indexAllPermission){
          $query->where('customer_id', $params->user->id);
        }
    */
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
