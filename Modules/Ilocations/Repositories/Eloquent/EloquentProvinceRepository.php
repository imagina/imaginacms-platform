<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ilocations\Repositories\ProvinceRepository;

class EloquentProvinceRepository extends EloquentBaseRepository implements ProvinceRepository
{
    public function index($page, $take, $filter, $include, $fields)
    {

        //Initialize Query
        $query = $this->model->query();
        $query->with('translations');


        /*== FILTER ==*/
        if ($filter) {
            /**
             * @deprecated use $filter->country instead
             */
            if (isset($filter->country_id))
                $query->where("country_id", $filter->country_id);
            if (isset($filter->country))
              $query->where("country_id", $filter->country);
        }

        /*== RELATIONSHIPS ==*/
        //Include relationships for default
        $includeDefault = [];
        $query->with(array_merge($includeDefault, $include));


        /*== FIELDS ==*/
        $defaultFields = ["id"];

        /*filter by user*/
        $query->select(array_merge($defaultFields, $fields));

        //Return request with pagination
        if ($page) {
            $take ? true : $take = 12; //If no specific take, query take 12 for default

            return $query->paginate($take);
        }

        //Return request without pagination
        if (!$page) {
            $take ? $query->take($take) : false; //if request to take a limit

            return $query->get()->sortBy('name');

        }


    }

    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['cities','country']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            if (isset($filter->country)) {
                $query->where("country_id", $filter->country);
            }
            if (isset($filter->countryCode)) {
                $code=$filter->countryCode;
                $query->whereHas("country", function ($q) use ($code) {
                    $q->where('iso_2',$code);
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
          //Initialize query
          $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if(in_array('*',$params->include)){//If Request all relationships
          $query->with([]);
        }else{//Especific relationships
          $includeDefault = [];//Default relationships
          if (isset($params->include))//merge relations with default relationships
            $includeDefault = array_merge($includeDefault, $params->include);
          $query->with($includeDefault);//Add Relationships to query
        }

          /*== FILTER ==*/
          if (isset($params->filter)) {
            $filter = $params->filter;

            if (isset($filter->field))//Filter by specific field
              $field = $filter->field;
          }

          /*== FIELDS ==*/
          if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

          /*== REQUEST ==*/
          return $query->where($field ?? 'id', $criteria)->first();
        }

    public function findByIso2($iso2)
    {
        return $this->model->where('iso_2', $iso2)->first();
    }
}
