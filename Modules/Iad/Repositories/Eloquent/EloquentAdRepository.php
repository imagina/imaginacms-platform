<?php

namespace Modules\Iad\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iad\Entities\Category;
use Modules\Iad\Repositories\AdRepository;
use Illuminate\Database\Eloquent\Builder;

class EloquentAdRepository extends EloquentCrudRepository implements AdRepository
{
  
  /**
   * Filter names to replace
   * @var array
   */
  protected $replaceFilters = [];
  
  /**
   * Relation names to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];
  
  /**
   * Filter query
   *
   * @param $query
   * @param $filter
   * @param $params
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {
    
    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */
  
    //Filter by category ID
    if (isset($filter->category) && !empty($filter->category)) {
    
    
      $categories = Category::descendantsAndSelf($filter->category);
    
      if ($categories->isNotEmpty()) {
        $query->where(function ($query) use ($categories) {
          $query->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('iad__ad_category.category_id', $categories->pluck("id"));
          });
        });
      }
    }
  
    // add filter by Categories 1 or more than 1, in array/*
    if (isset($filter->categories) && !empty($filter->categories)) {
      is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
      $query->where(function ($query) use ($filter) {
        $query->whereHas('categories', function ($query) use ($filter) {
          $query->whereIn('iad__ad_category.category_id', $filter->categories);
        });
      });
    
    }
  
    // add filter by Price Range
    if (isset($filter->priceRange) && !empty($filter->priceRange)) {
    
      $query->where("min_price", '>=', $filter->priceRange->from);
      $query->where("max_price", '<=', $filter->priceRange->to);
    
    }
  
    // add filter by Age Range
    if (isset($filter->ageRange) && !empty($filter->ageRange)) {
    
      $query->where(function ($query) use ($filter) {
        $query->whereHas('fields', function ($query) use ($filter) {
          $query->where('iad__fields.name', 'age', function ($query) use ($filter) {
          
            //$query->whereBetween('age',[$filter->ageRange->from,$filter->ageRange->to]);
          
          })->whereBetween('iad__fields.value', [(int)$filter->ageRange->from, (int)$filter->ageRange->to]);
        });
      });
    
    }
  
    // add filter by Antiquity Range
    if (isset($filter->antiquityRange) && !empty($filter->antiquityRange)) {
    
      $query->where(function ($query) use ($filter) {
        $query->whereHas('fields', function ($query) use ($filter) {
          $query->where('iad__fields.name', 'antiquity', function ($query) use ($filter) {
          })->whereBetween('iad__fields.value', [(int)$filter->antiquityRange->from, (int)$filter->antiquityRange->to]);
        });
      });
    }
  
    // add filter by nearby
    if (isset($filter->nearby) && $filter->nearby) {
    
      if(isset($filter->nearby->findByLngLat) && $filter->nearby->findByLngLat==false){
      
        //dd($filter->nearby);
      
        $query->whereHas('country', function ($query) use ($filter) {
          $query->where('ilocations__countries.iso_2', $filter->nearby->country);
        });
      
      
        //Departments
        if(!is_null($filter->nearby->province)){
        
          //Cuando se busca "Bogota", google trae dpto Bogota, y esto no existe en el ilocations sino como ciudad
          if($filter->nearby->province!="Bogotá"){
            $query->whereHas('province', function ($query) use ($filter) {
              $query->leftJoin('ilocations__province_translations as pt', 'pt.province_id', 'ilocations__provinces.id')
                ->where("pt.name", "like", "%" . $filter->nearby->province . "%");
            });
            \Log::info("Province: ".$filter->nearby->province);
          }else{
            \Log::info("Province: Bogota-Formateo por Ilocations Google");
            //Se agrega ciudad para este caso y no entre en la condicion de neighborhood solo para este caso
            $filter->nearby->city="Bogotá";
          
          }
        
        
        }
      
        if(isset($filter->nearby->city) && !is_null($filter->nearby->city)){
        
          $query->whereHas('city', function ($query) use ($filter) {
            $query->leftJoin('ilocations__city_translations as ct', 'ct.city_id', 'ilocations__cities.id')
              ->where("ct.name", "like", "%" . $filter->nearby->city . "%");
          });
        
          \Log::info("City: ".$filter->nearby->city);
        
        }
      
        //Esto es xq google sino se coloca barrio trae la misma localidad para ambas
        if(!isset($filter->nearby->city) || $filter->nearby->neighborhood!=$filter->nearby->city){
        
        
          // Google a veces retorna direcciones como rutas en vez de barrios
          // se formatea para que lo pueda encontrar en el ilocations
          $words = config("asgard.iad.config.location-range.googleWordsMap");
          if(is_null($words))
            $words = array('Av.','Localidad de'); //default - Route Google
        
          $searchResult = trim(str_replace($words,'',$filter->nearby->neighborhood));
        
          \Log::info("Neighborhood:".$searchResult);
        
          // Query
          $query->whereHas('neighborhood', function ($query) use ($filter,$searchResult) {
            $query->leftJoin('ilocations__neighborhood_translations as nt', 'nt.neighborhood_id', 'ilocations__neighborhoods.id')
              ->where("nt.name", "like", "%" . $searchResult . "%");
          });
        
          //Old
          /*
          $query->whereHas('neighborhood', function ($query) use ($filter) {
              $query->leftJoin('ilocations__neighborhood_translations as nt', 'nt.neighborhood_id', 'ilocations__neighborhoods.id')
                ->where("nt.name", "like", "%" . $filter->nearby->neighborhood . "%");
          });
          */
        
        }
      
      }else{
      
      
        if (!empty($filter->nearby->lat) && !empty($filter->nearby->lng)) {
        
          if ($filter->nearby->radio == "all") {
          
            if (isset($filter->nearby->lat) && isset($filter->nearby->lng) && !empty($filter->nearby->lat) && !empty($filter->nearby->lng)) {
              $query->select("*", \DB::raw("SQRT(
              POW(69.1 * (lat - " . $filter->nearby->lat . "), 2) +
              POW(69.1 * (" . $filter->nearby->lng . " - lng) * COS(lat / 57.3), 2)) AS radio"))
                ->having('radio', '<', (int)setting('iad::ratioLocationFilter') ?? 20);
            } else {
              if (isset($filter->nearby->country) && !empty($filter->nearby->country)) {
                $query->whereHas('country', function ($query) use ($filter) {
                  $query->where('ilocations__countries.iso_2', $filter->nearby->country);
                });
              }
              if (isset($filter->nearby->province) && !empty($filter->nearby->province)) {
                $query->whereHas('province', function ($query) use ($filter) {
                  $query->leftJoin('ilocations__province_translations as pt', 'pt.province_id', 'ilocations__provinces.id')
                    ->where("pt.name", "like", "%" . $filter->nearby->province . "%");
                });
              }
              if (isset($filter->nearby->city) && !empty($filter->nearby->city)) {
                $query->whereHas('city', function ($query) use ($filter) {
                  $query->leftJoin('ilocations__city_translations as ct', 'ct.city_id', 'ilocations__cities.id')
                    ->where("ct.name", "like", "%" . $filter->nearby->city . "%");
                });
              }
            }
          } else {
            if (!empty($filter->nearby->lat) && !empty($filter->nearby->lng)) {
              $query->select("*", \DB::raw("SQRT(
              POW(69.1 * (lat - " . $filter->nearby->lat . "), 2) +
              POW(69.1 * (" . $filter->nearby->lng . " - lng) * COS(lat / 57.3), 2)) AS radio"))
                ->having('radio', '<', $filter->nearby->radio);
            }
          }
        }
      }
    }
  
    //Filter by city id
    // City ID is 0 when name is "ALL / TODOS"
    //Comentado para descartar que la Base logre el mismo resultado con el dynamic query
    //if (isset($filter->cityId) && $filter->cityId != 0) {
    //  $query->where("iad__ads.city_id", $filter->cityId);
    //}
  
    //Filter Search
    if (isset($filter->search) && !empty($filter->search)) {
      $criterion = $filter->search;
    
      $query->whereHas('translations', function (Builder $q) use ($criterion) {
        $q->where('title', 'like', "%{$criterion}%");
        $q->orWhere('description', 'like', "%{$criterion}%");
      });
    
    }
  
    $this->validateIndexAllPermission($query, $params);
  
    //Response
    return $query;
  }
  
  
  /**
   * Method to include relations to query
   * @param $query
   * @param $relations
   */
  public function includeToQuery($query, $relations)
  {
  
    //In the autocomplete filter they send the category
    //This relation not exist in AD entity
    $categoryRelation = array_search("category",$relations ?? []);
    if(!is_null($categoryRelation)) {
      $relations[$categoryRelation] = "categories";
    }
    
    //request all categories instances in the "relations" attribute in the entity model
    if (in_array('*', $relations)) $relations = $this->model->getRelations() ?? ['files','translations'];
    //Instance relations in query
    $query->with($relations);
    //Response
    return $query;
  }
  
  /**
   * Method to sync Model Relations
   *
   * @param $model ,$data
   * @return $model
   */
  public function syncModelRelations($model, $data)
  {
    //Get model relations data from attribute of model
    $modelRelationsData = ($model->modelRelations ?? []);
  
    if(isset($data['categories']) && !empty($data['categories'])){
      $model->categories()->sync($data['categories']);
    }
    if(isset($data['fields']) && !empty($data['fields'])){
      $model->fields()->delete();
      $model->fields()->createMany($data['fields']);
    }
    if(isset($data['schedule']) && !empty($data['schedule'])){
      $model->schedule()->delete();
      $model->schedule()->createMany($data['schedule']);
    }

    
    
    //Response
    return $model;
  }
  
  public function beforeUpdate(&$data)
  {
    if (isset($data["uploaded_at"]))
      unset($data["uploaded_at"]);
  }
  

  public function getPriceRange($params = false)
  {
    isset($params->take) ? $params->take = false : false;
    isset($params->page) ? $params->page = null : false;
    isset($params->include) ? $params->include = [] : false;

    isset($params->filter->priceRange) ? $params->filter->priceRange = null : false;

    if (isset($params->filter->order)) $params->filter->order = false;
    isset($params->filter) ? empty($params->filter) ? $params->filter = (object)["noSortOrder" => true] : $params->filter->noSortOrder = true : false;
    $params->onlyQuery = true;
    $params->order = false;

    $query = $this->getItemsBy($params);

    $query->select(
      \DB::raw("MIN(iad__ads.min_price) AS minPrice"),
      \DB::raw("MAX(iad__ads.max_price) AS maxPrice")
    );

    return $query->first();
  }


  function validateIndexAllPermission(&$query, $params)
  {
    // filter by permission: index all leads

    if (!isset($params->permissions['iad.ads.index-all']) ||
      (isset($params->permissions['iad.ads.index-all']) &&
        !$params->permissions['iad.ads.index-all'])) {
      $user = $params->user ?? null;

      if (isset($user->id)) {
        // if is salesman or salesman manager or salesman sub manager
        $query->where('user_id', $user->id);

      }


    }
  }
}
