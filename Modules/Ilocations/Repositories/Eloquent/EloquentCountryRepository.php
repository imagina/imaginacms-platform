<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Ilocations\Repositories\CountryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCountryRepository extends EloquentBaseRepository implements CountryRepository
{

  public function index($page, $take, $filter, $include, $fields)
  {

    //Initialize Query
    $query = $this->model->query();
    $query->with('translations');
    $query->where("status","<>","-1");
    /*== FILTER ==*/
    if ($filter) {
        if (isset($filter->search)) { //si hay que filtrar por rango de precio
            $criterion = $filter->search;
            $param = explode(' ', $criterion);
            $query->where(function ($query) use ($param) {
                foreach ($param as $index => $word) {
                    if ($index == 0) {
                        $query->where('name', 'like', "%" . $word . "%");
                        $query->orWhere('full name', 'like', "%" . $word . "%");
                    } else {
                        $query->orWhere('title', 'like', "%" . $word . "%");
                        $query->orWhere('sku', 'like', "%" . $word . "%");
                    }
                }

            });
        }
    }

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];

      $query->with(array_merge($includeDefault, $include));
    }

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

  public function findByIso2($iso2){
    return $this->model->where('iso_2',$iso2)->first();
  }


  public function getItem($criteria, $params = false)
      {
        //Initialize query
        $query = $this->model->query();

      /*== RELATIONSHIPS ==*/
      if(in_array('*',$params->include)){//If Request all relationships
        $query->with(['provinces','cities']);
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

      public function getItemsBy($params = false)
        {
          /*== initialize query ==*/
          $query = $this->model->query();

          /*== RELATIONSHIPS ==*/
          if(in_array('*',$params->include ?? [])){//If Request all relationships
            $query->with(['provinces','cities','translations']);
          }else{//Especific relationships
            $includeDefault = ['translations'];//Default relationships
            if (isset($params->include))//merge relations with default relationships
              $includeDefault = array_merge($includeDefault, $params->include ?? []);
            $query->with($includeDefault);//Add Relationships to query
          }

          /*== FILTERS ==*/
          if (isset($params->filter)) {
            $filter = $params->filter;//Short filter

            //filter by Id
            if (isset($filter->id)) {
              $query->whereIn('id', (array)$filter->id);
            }

            if(isset($filter->iso2)){
              if(is_array($filter->iso2))
                $query->whereIn('iso_2',$filter->iso2);
              else
                $query->where('iso_2',$filter->iso2);
            }

              if (isset($filter->search)) {
                $query->where(function ($query) use ($filter) {
                  $query->whereHas('translations', function ($query) use ($filter) {
                    $query->where('locale', $filter->locale)
                      ->where('name', 'like', '%' . $filter->search . '%')
                      ->orWhere('full_name', 'like', '%' . $filter->search . '%');
                  })->orWhere('ilocations__countries.id', 'like', '%' . $filter->search . '%')
                    ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                    ->orWhere('created_at', 'like', '%' . $filter->search . '%');
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

            // ORDER
            if (isset($filter->order) && $filter->order) {

              $order = is_array($filter->order) ? $filter->order : [$filter->order];

              foreach ($order as $orderObject) {
                if (isset($orderObject->field) && isset($orderObject->way)) {
                  if (in_array($orderObject->field, $this->model->translatedAttributes)) {
                    $query->orderByTranslation($orderObject->field, $orderObject->way);
                  } else
                    $query->orderBy($orderObject->field, $orderObject->way);
                }

              }
            }
          }

          $availableCountries = json_decode(setting("ilocations::availableCountries", null, "[]"));
          /*=== SETTINGS ===*/
          if (!empty($availableCountries) && !isset($params->filter->indexAll)) {
            if (!isset($params->permissions['ilocations.countries.manage']) || (!$params->permissions['ilocations.countries.manage'])) {

              $query->whereIn('iso_2', $availableCountries);

            }
          }

          /*== FIELDS ==*/
          if (isset($params->fields) && count($params->fields))
            $query->select($params->fields);

          /*== REQUEST ==*/
          //dd($query->toSql(),$query->getBindings(),$params);
          if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
          } else {
            isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
            return $query->get();
          }
        }

}
