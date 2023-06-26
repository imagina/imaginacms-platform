<?php

namespace Modules\Iappointment\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iappointment\Repositories\AppointmentStatusRepository;

class EloquentAppointmentStatusRepository extends EloquentBaseRepository implements AppointmentStatusRepository
{
    /**
     * Standard Api Method
     *
     * @param  bool  $params
     * @return mixed
     */
    public function getItemsBy(bool $params = false)
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
            if (isset($filter->parent)) {
                $query->where('parent_id', $filter->parent);
            }

            if (isset($filter->search)) { //si hay que filtrar por rango de precio
                $criterion = $filter->search;
                $param = explode(' ', $criterion);
                $criterion = $filter->search;
                //find search in columns
                $query->where(function ($query) use ($criterion) {
                    $query->whereHas('translations', function (Builder $q) use ($criterion) {
                        $q->where('title', 'like', "%{$criterion}%");
                    });
                })->orWhere('id', 'like', '%'.$filter->search.'%');
            }

            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date; //Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from)) {//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                }
                if (isset($date->to)) {//to a date
                    $query->whereDate($date->field, '<=', $date->to);
                }
            }

            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('iappointment__appointment_statuses.id', $filter->ids);
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
    public function getItem($criteria, bool $params = false)
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

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

      // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes)) {//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                      ->where($field, $criteria);
                });
            } else {
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
            }
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
    public function create($data)
    {
        $model = $this->model->create($data);

        return $this->find($model->id);
    }

    /**
     * Standard Api Method
     *
     * @param  bool  $params
     * @return bool
     */
    public function updateBy($criteria, $data, bool $params = false): bool
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

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        $model ? $model->update((array) $data) : false;

        return $model;
    }

    /**
     * Standard Api Method
     *
     * @param  bool  $params
     */
    public function deleteBy($criteria, bool $params = false)
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
