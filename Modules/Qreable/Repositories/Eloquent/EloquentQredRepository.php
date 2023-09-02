<?php

namespace Modules\Qreable\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Qreable\Repositories\QredRepository;

class EloquentQredRepository extends EloquentBaseRepository implements QredRepository
{
    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }
        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) {//Filter by specific field
                $field = $filter->field;
            }

            // find by specific attribute or by id
            $query->where($field ?? 'id', $criteria);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        if (! isset($params->filter->field)) {
            $query->where('id', $criteria);
        }

        /*== REQUEST ==*/
        return $query->first();
    }

    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();
//    dd('___________________________________________________',$params->filter);

        /*== RELATIONSHIPS ==*/
        $includeDefault = ['translations']; //Default relationships
        if (isset($params->include)) {//merge relations with default relationships
            $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('id', $filter->ids);
            }

            if (isset($filter->qreableId)) {
                is_array($filter->qreableId) ? true : $filter->qreableId = [$filter->qreableId];
                $query->whereIn('qreable_id', $filter->qreableId);
            }

            if (isset($filter->qreableType)) {
                is_array($filter->qreableType) ? true : $filter->qreableType = [$filter->qreableType];
                $query->whereIn('qreable_type', $filter->qreableType);
            }

            if (isset($filter->zone)) {
                is_array($filter->zone) ? true : $filter->zone = [$filter->zone];
                $query->whereIn('zone', $filter->zone);
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }
        }

        /*== FIELDS ==*/

        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            if (isset($params->take)) {
                $query->take($params->take);
            }

            return $query->get();
        }
    }
}
