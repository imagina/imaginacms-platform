<?php

namespace Modules\Ibooking\Repositories\Eloquent;

use Modules\Ibooking\Repositories\ReservationItemRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentReservationItemRepository extends EloquentCrudRepository implements ReservationItemRepository
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
    //Filter by user ID
    if (isset($filter->userId)) {
      $query->where(function ($q) use ($filter) {
        $q->where('customer_id', $filter->userId)
          ->orWhereIn('resource_id', function ($sq) use ($filter) {
            $sq->select('id')->from('ibooking__resources')->where('created_by', $filter->userId);
          });
      });
    }

    //Response
    return $query;
  }

}
