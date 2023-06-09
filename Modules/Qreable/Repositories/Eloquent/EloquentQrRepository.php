<?php

namespace Modules\Qreable\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Qreable\Repositories\QrRepository;

class EloquentQrRepository extends EloquentBaseRepository implements QrRepository
{
    /**
     * Standard Api Method
     *
     * @param  bool  $params
     * @return mixed
     */
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('id', $filter->ids);
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
            $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    /**
     * Standard Api Method
     *
     * @param  bool  $params
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
}
