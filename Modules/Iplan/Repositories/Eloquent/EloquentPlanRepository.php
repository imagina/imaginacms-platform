<?php

namespace Modules\Iplan\Repositories\Eloquent;

use Modules\Iplan\Repositories\PlanRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentPlanRepository extends EloquentCrudRepository implements PlanRepository
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
  
    if (isset($filter->category) && !empty($filter->category)) {
      $query->where(function ($query) use ($filter) {
        $query->whereHas('categories', function ($query) use ($filter) {
          $query->whereIn('iplan__plan_category.category_id', [$filter->category]);
        })->orWhereIn('iplan__plans.category_id', [$filter->category]);
      });
    }
  
    if (isset($filter->categories) && !empty($filter->categories)) {
      is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
      $query->where(function ($query) use ($filter) {
        $query->whereHas('categories', function ($query) use ($filter) {
          $query->whereIn('iplan__plan_category.category_id', $filter->categories);
        })->orWhereIn('iplan__plans.category_id', $filter->categories);
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

    if (isset($filter->exclude) && !empty($filter->exclude)) {
      $exclude = is_array($filter->exclude) ? $filter->exclude : [$filter->exclude];
      $query->whereNotIn('id', $exclude);
    }
  
  
    //Order by "Sort order"
    if (!isset($params->filter->noSortOrder) || !$params->filter->noSortOrder) {
      $query->orderBy('sort_order', 'desc');//Add order to query
    }

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
  
    if(isset($data['limits']) && !empty($data['limits'])){
      $model->limits()->sync($data['limits']);
    }
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
