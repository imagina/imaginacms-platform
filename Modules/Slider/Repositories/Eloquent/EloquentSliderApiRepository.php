<?php

namespace Modules\Slider\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Repositories\SliderApiRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentSliderApiRepository extends EloquentBaseRepository implements SliderApiRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (isset($params->include) && in_array('*', $params->include)) {//If Request all relationships
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

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                //find search in columns Customer_name and Customer_Last_Name
                $query->where(function ($query) use ($filter) {
                    $query->where('id', 'like', '%'.$filter->search.'%')
                      ->orWhere('name', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
            }

            //Filter by slug
            if (isset($filter->sliderId)) {
                $query->where('slider_id', $filter->sliderId);
            }
            //Filter by slug
            if (isset($filter->systemName)) {
                $query->where('system_name', $filter->systemName);
            }

            if (isset($filter->id)) {
                ! is_array($filter->id) ? $filter->id = [$filter->id] : false;
                $query->where('id', $filter->id);
            }
        }
        $entitiesWithCentralData = json_decode(setting('isite::tenantWithCentralData', null, '[]', true));
        $tenantWithCentralData = in_array('slider', $entitiesWithCentralData);

        if ($tenantWithCentralData && isset(tenant()->id)) {
            $model = $this->model;

            if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin == false) {
                $query->withoutTenancy();
            }

            $query->where(function ($query) use ($model) {
                $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
                  ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
            });
        }

        /*
        if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
          $query->withTenancy();
        }
        */

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            //return $query->paginate($params->take);
            return $query->paginate($params->take, ['*'], null, $params->page);
        } else {
            isset($params->take) && $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
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
        }

        $entitiesWithCentralData = json_decode(setting('isite::tenantWithCentralData', null, '[]', true));
        $tenantWithCentralData = in_array('slider', $entitiesWithCentralData);

        if ($tenantWithCentralData && isset(tenant()->id)) {
            $model = $this->model;

            $query->withoutTenancy();
            $query->where(function ($query) use ($model) {
                $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
                  ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
            });
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    public function index($page, $take, $filter, $include)
    {
        //Initialize Query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = [];
            $query->with(array_merge($includeDefault, $include));
        }

        /*== FILTER ==*/
        if ($filter) {
            //Filter by slug
            if (isset($filter->sliderId)) {
                $query->where('slider_id', $filter->sliderId);
            }
        }

        /*=== REQUEST ===*/
        if ($page) {//Return request with pagination
            $take ? true : $take = 12; //If no specific take, query default take is 12

            return $query->paginate($take);
        } else {//Return request without pagination
            $take ? $query->take($take) : false; //Set parameter take(limit) if is requesting

            return $query->get();
        }
    }

    public function show($id, $include)
    {
        //Initialize Query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (count($include)) {
            //Include relationships for default
            $includeDefault = [];
            $query->with(array_merge($includeDefault, $include));
        }

        $query->where('id', $id);

        /*=== REQUEST ===*/
        return $query->first();
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

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();

        return $model ? $model->update((array) $data) : false;
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
