<?php

namespace Modules\Ilocations\Repositories\Eloquent;

use Modules\Ilocations\Repositories\NeighborhoodRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentNeighborhoodRepository extends EloquentBaseRepository implements NeighborhoodRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['city']);
        } else {//Especific relationships
            $includeDefault = [];//Default relationships
            if (isset($params->include))//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            $query->with($includeDefault);//Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;//Short filter
  
          if (isset($filter->search)) {
            $query->where(function ($query) use ($filter) {
              $query->whereHas('translations', function ($query) use ($filter) {
                $query->where('locale', $filter->locale)
                  ->where('name', 'like', '%' . $filter->search . '%');
              })->orWhere('ilocations__neighborhoods.id', 'like', '%' . $filter->search . '%')
                ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
                ->orWhere('created_at', 'like', '%' . $filter->search . '%');
            });
    
          }

            if (isset($filter->city))
                $query->where("city_id", $filter->city);
            
            if (isset($filter->cityId)){
              !is_array($filter->cityId) ? $filter->cityId = [$filter->cityId] : false;
              $query->whereIn("city_id", $filter->cityId);
            }
            
            if (isset($filter->provinceId)){
              !is_array($filter->provinceId) ? $filter->provinceId = [$filter->provinceId] : false;
              $query->whereIn("province_id", $filter->provinceId);
            }
            
            if (isset($filter->countryId)){
              !is_array($filter->countryId) ? $filter->countryId = [$filter->countryId] : false;
              $query->whereIn("country_id", $filter->countryId);
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
  
  
  
      $availableCountries = json_decode(setting("ilocations::availableCountries", null, "[]"));
      /*=== SETTINGS ===*/
      if (!empty($availableCountries) && !isset($params->filter->indexAll)) {
        if (!isset($params->permissions['ilocations.neighborhoods.manage']) || (!$params->permissions['ilocations.neighborhoods.manage'])) {
          $query->whereHas("country", function ($query) use ($availableCountries){
            $query->whereIn("ilocations__countries.iso_2",$availableCountries);
          });
      
        }
      }
  
      $availableProvinces = json_decode(setting("ilocations::availableProvinces", null, "[]"));
  
      /*=== SETTINGS ===*/
      if (!empty($availableProvinces) && !isset($params->filter->indexAll)) {
        if (!isset($params->permissions['ilocations.neighborhoods.manage']) || (!$params->permissions['ilocations.neighborhoods.manage'])) {
          $query->whereHas("province", function ($query) use ($availableProvinces){
            $query->whereIn("ilocations__provinces.iso_2",$availableProvinces);
          });
      
        }
      }
  
  
      $availableCities = json_decode(setting("ilocations::availableCities", null, "[]"));
  
      /*=== SETTINGS ===*/
      if (!empty($availableCities) && !isset($params->filter->indexAll)) {
        if (!isset($params->permissions['ilocations.neighborhoods.manage']) || (!$params->permissions['ilocations.neighborhoods.manage'])) {
      
          $query->whereIn('ilocations__neighborhoods.city_id', $availableCities);
      
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
            $query->with(['city']);
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
}
