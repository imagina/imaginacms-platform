<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Ilocations\Entities\Geozones;
use Modules\Ilocations\Entities\GeozonesCountries;
use Modules\Ilocations\Repositories\GeozonesRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentGeozonesRepository extends EloquentBaseRepository implements GeozonesRepository
{
  public function getAll(){
    return $this->model->orderBy('name','asc')->get();
  }

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['province','country']);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter


      if (isset($filter->country))
        $query->where("country_id", $filter->country);

      if (isset($filter->province))
        $query->where("province_id", $filter->province);

      /* Filter for address */
      if(
        isset($filter->address) &&
        isset($filter->address->city) &&
        isset($filter->address->province) &&
        isset($filter->address->country)
      ){

        $query->whereHas('cities', function ($query) use ($filter) {
          $query->where('ilocations__cities.id', $filter->address->city);
        });

        $query->orWhereHas('countries', function ($query) use ($filter) {
          $query->where('ilocations__countries.id', $filter->address->country);
        });

        $query->orWhereHas('provinces', function ($query) use ($filter) {
          $query->where('ilocations__provinces.id', $filter->address->province);
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
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['province','country']);
    } else {//Especific relationships
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

  public function create($data)
  {
      /**
       * @var Geozones $model
       */
        $model = $this->model->create($data);

        if ($model) {
            if(isset($data['zones_to_geozone'])){
                $model->zonesToGeozone()->createMany($data['zones_to_geozone']);
            }
        }
        return $model;
  }

  public function update($criteria, $data, $params = false)
  {
      /*== initialize query ==*/
      $query = $this->model->query();

      /*== FILTER ==*/
      if (isset($params->filter)) {
          $filter = $params->filter;

          //Update by field
          if (isset($filter->field))
              $field = $filter->field;
      }

      /*== REQUEST ==*/
      /**
       * @var Geozones $model
       */
      $model = $query->where($field ?? 'id', $criteria)->first();

      $model->update((array)$data);

      if ($model) {
          if(isset($data['zones_to_geozone'])) {
              $model->zonesToGeozone()->delete();
              $model->zonesToGeozone()->createMany($data['zones_to_geozone']);
          }
          return $model;
      }
      return false;

  }
}
