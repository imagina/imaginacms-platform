<?php

namespace Modules\Iforms\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iforms\Repositories\FormRepository;

class EloquentFormRepository extends EloquentBaseRepository implements FormRepository
{
    public function getItemsBy($params)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();
        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }
        // FILTERS
        if ($params->filter) {
            $filter = $params->filter;
            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($query) use ($filter) {
                        $query->where('locale', $filter->locale)
                            ->where('title', 'like', $filter->search . '%');
                    })->orWhere('id', 'like', $filter->search . '%')->orWhere('system_name', 'like', $filter->search . '%');
                });
            }
            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date;//Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from))//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                if (isset($date->to))//to a date
                    $query->whereDate($date->field, '<=', $date->to);
            }
            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at';//Default field
                $orderWay = $filter->order->way ?? 'desc';//Default way
                $query->orderBy($orderByField, $orderWay);//Add order to query
            }
            //Filter by parent ID
            if (isset($filter->userId) && !empty($filter->userId)) {
                $query->where("user_id", $filter->userId);
            }
        }
        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        // INITIALIZE QUERY
        $query = $this->model->query();
        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }
        /*== FIELDS ==*/
        if (is_array($params->fields) && count($params->fields))
            $query->select($params->fields);
        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;
            if (isset($filter->field))//Filter by specific field
                $field = $filter->field;
            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;
            // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                        ->where($field, $criteria);
                });
            else
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
        }
        /*== REQUEST ==*/
        return $query->first();
    }

    public function create($data)
    {
        $form = $this->model->create($data);
        if ($form) {
            $form->fields()->update(array_get($data, 'fields', []));
        }
        return $form;
    }


    /**
     * @param string $systemName
     * @return Slider
     */
    public function findBySystemName($systemName)
    {
        return $this->model->with('translations','fields')->where('system_name', '=', $systemName)->first();
    }
}
