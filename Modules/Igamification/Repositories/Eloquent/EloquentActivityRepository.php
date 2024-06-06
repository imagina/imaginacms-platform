<?php

namespace Modules\Igamification\Repositories\Eloquent;

use Modules\Igamification\Repositories\ActivityRepository;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;

class EloquentActivityRepository extends EloquentCrudRepository implements ActivityRepository
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
  public function filterQuery($query, $filter)
  {

    /**
     * Note: Add filter name to replaceFilters attribute before replace it
     *
     * Example filter Query
     * if (isset($filter->status)) $query->where('status', $filter->status);
     *
     */

      // add filter by Categories 1 or more than 1, in array/*
    /*
    if (isset($filter->categories) && !empty($filter->categories)) {
        is_array($filter->categories) ? true : $filter->categories = [$filter->categories];

        //dd($filter->categories);

        $query->where(function ($query) use ($filter) {
          $query->whereHas('categories', function ($query) use ($filter) {
            $query->whereIn('igamification__activity_category.category_id', $filter->categories);
          })->orWhereIn('category_id', $filter->categories);
        });

    }
    */

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
