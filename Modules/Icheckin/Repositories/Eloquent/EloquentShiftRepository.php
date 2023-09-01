<?php

namespace Modules\Icheckin\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icheckin\Entities\Shift;
use Modules\Icheckin\Repositories\ShiftRepository;

class EloquentShiftRepository extends EloquentBaseRepository implements ShiftRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            if (! isset($params->permissions['icheckin.shifts.index-all']) || ! $params->permissions['icheckin.shifts.index-all']) {
                $query->where('checkin_by', $params->user->id);
            } else {
                if (isset($params->settings['assignedDepartments']) && count($params->settings['assignedDepartments'])) {
                    $query->whereIn('checkin_by', $filter->usersByDepartment);
                }
            }

            //Filter by date
            if (isset($filter->date) && ! empty($filter->date)) {
                $date = $filter->date; //Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from)) {//From a date
                    $query->where($date->field, '>=', $date->from);
                }
                if (isset($date->to)) {//to a date
                    $query->where($date->field, '<=', $date->to);
                }
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            } else {
                $query->orderBy('checkin_at', 'desc'); //Add order to query
                $query->orderBy('checkout_at', 'asc'); //Add order to query
            }

            if (isset($filter->repId) && $filter->repId) {
                $query->where('checkin_by', $filter->repId);
            }

            if (isset($filter->active) && $filter->active) {
                $query->whereNull('checkout_at');
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->where('id', 'like', '%'.$filter->search.'%')
                      ->orWhereHas('checkinBy', function ($query) use ($filter) {
                          $query->where('users.first_name', 'like', '%'.$filter->search.'%');
                          $query->orWhere('users.last_name', 'like', '%'.$filter->search.'%');
                      })
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        //Return as query
        if (isset($params->returnAsQuery) && $params->returnAsQuery) {
            return $query;
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
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

            if (isset($filter->noCheckout) && $filter->noCheckout) {
                $query->whereNull('checkout_at');
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    public function create($data)
    {
        $shift = $this->model->create($data);

        $shiftApproved = Shift::where('checkin_by', $shift->checkin_by)
          ->whereRaw('DATE_FORMAT(checkin_at,"%Y/%m/%d") = DATE_FORMAT("'.$shift->checkin_at.'","%Y/%m/%d")')
          ->whereNotNull('approval_id')
          ->first();

        if ($shiftApproved) {
            $shift->approval_id = $shiftApproved->approval_id;
            $shift->save();
        }

        return $shift;
    }

    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Update by field
            if (isset($filter->field)) {
                $field = $filter->field;
            }
        }
        $model = $query->where($field ?? 'id', $criteria)->first();
        /*== REQUEST ==*/
        if ($model) {
            if (isset($data['checkin_by']) && is_array($data['checkin_by'])) {
                unset($data['checkin_by']);
            }

            if (isset($data['checkout_by']) && is_array($data['checkout_by'])) {
                unset($data['checkout_by']);
            }

            $model->update((array) $data);
        }

        return $model;
    }

    public function deleteBy($criteria, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field)) {//Where field
                $field = $filter->field;
            }
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        $model ? $model->delete() : false;
    }
}
