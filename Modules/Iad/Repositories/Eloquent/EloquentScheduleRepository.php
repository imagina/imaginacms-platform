<?php

namespace Modules\Iad\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iad\Repositories\ScheduleRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentScheduleRepository extends EloquentCrudRepository implements ScheduleRepository
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
   * @return mixed
   */
  public function filterQuery($query, $filter, $params)
  {
    
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
    
    /**
     * Note: Add relation name to replaceSyncModelRelations attribute before replace it
     *
     * Example to sync relations
     * if (array_key_exists(<relationName>, $data)){
     *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
     * }
     *
     */
    
    //Response
    return $model;
  }
}
