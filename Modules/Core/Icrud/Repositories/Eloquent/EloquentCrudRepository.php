<?php

namespace Modules\Core\Icrud\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Core\Icrud\Repositories\BaseCrudRepository;

/**
 * Class EloquentCrudRepository
 *
 * @package Modules\Core\Repositories\Eloquent
 */
abstract class EloquentCrudRepository extends EloquentBaseRepository implements BaseCrudRepository
{
  /**
   * Filter name to replace
   * @var array
   */
  protected $replaceFilters = [];

  /**
   * Relation name to replace
   * @var array
   */
  protected $replaceSyncModelRelations = [];

  /**
   * Method to include relations to query
   * @param $query
   * @param $relations
   */
  public function includeToQuery($query, $relations)
  {
    //request all categories instances in the "relations" attribute in the entity model
    if (in_array('*', $relations)) $relations = $this->model->getRelations() ?? [];
    //Instance relations in query
    $query->with($relations);
    //Response
    return $query;
  }

  /**
   * Method to set default model filters by attributes
   *
   * @param $query
   * @param $filter
   * @param $fieldName
   * @return mixed
   */
  public function setFilterQuery($query, $filterData, $fieldName)
  {
    $filterWhere = $filterData->where ?? null;//Get filter where condition
    $filterOperator = $filterData->operator ?? '=';// Get filter operator
    $filterValue = $filterData->value ?? $filterData;//Get filter value

    //Set where condition
    if ($filterWhere == 'in') {
      $query->whereIn($fieldName, $filterValue);
    } else if ($filterWhere == 'notIn') {
      $query->whereNotIn($fieldName, $filterValue);
    } else if ($filterWhere == 'between') {
      $query->whereBetween($fieldName, $filterValue);
    } else if ($filterWhere == 'notBetween') {
      $query->whereNotBetween($fieldName, $filterValue);
    } else if ($filterWhere == 'null') {
      $query->whereNull($fieldName);
    } else if ($filterWhere == 'notNull') {
      $query->whereNotNull($fieldName);
    } else if ($filterWhere == 'date') {
      $query->whereDate($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'year') {
      $query->whereYear($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'month') {
      $query->whereMonth($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'day') {
      $query->whereDay($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'time') {
      $query->whereTime($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'column') {
      $query->whereColumn($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'orWhere') {
      $query->orWhere($fieldName, $filterOperator, $filterValue);
    } else if ($filterWhere == 'belongsToMany') {
      //Sub query to get data by pivot
      $query->whereIn('id', function ($q) use ($filterData, $filterValue) {
        //validate filter value
        if (!is_array($filterValue)) $filterValue = [$filterValue];
        //filter sub query
        $q->select($filterData->foreignPivotKey)->from($filterData->table)
          ->whereIn($filterData->relatedPivotKey, $filterValue);
      });
    } else {
      $query->where($fieldName, $filterOperator, $filterValue);
    }

    //Response
    return $query;
  }

  /**
   * Method to filter query
   * @param $query
   * @param $filter
   */
  public function filterQuery($query, $filter)
  {
    return $query;
  }

  /**
   * Method to order Query
   *
   * @param $query
   * @param $filter
   */
  public function orderQuery($query, $order)
  {
    $orderField = $order->field ?? 'created_at';//Default field
    $orderWay = $order->way ?? 'desc';//Default way

    //Set order to query
    if (in_array($orderField, ($this->model->translatedAttributes ?? []))) {
      $query->orderByTranslation($orderField, $orderWay);
    } else $query->orderBy($orderField, $orderWay);

    //Return query with filters
    return $query;
  }

  /**
   * Method to sync Model Relations by default
   *
   * @param $model ,$data
   * @return $model
   */
  public function defaultSyncModelRelations($model, $data)
  {
    foreach (($model->modelRelations ?? []) as $relationName => $relationType) {
      // Check if exist relation in data
      if (!in_array($relationName, $this->replaceSyncModelRelations) && array_key_exists($relationName, $data)) {
        // Sync Has Many relation
        if ($relationType == "hasMany") {
          // Validate if exist relation with items
          $model->$relationName()->forceDelete();
          // Create and Set relation to Model
          $model->setRelation($relationName, $model->$relationName()->createMany($data[$relationName]));
        }

        // Sync Belongs to many relation
        if ($relationType == "belongsToMany") {
          $model->$relationName()->sync($data[$relationName]);
          $model->setRelation($relationName, $model->$relationName);
        }
      }
    }

    //Response
    return $model;
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
     * Note: Add relation name to replaceSyncModelRelations attribute to replace it
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

  /**
   * Method to create model
   *
   * @param $data
   * @return mixed
   */
  public function create($data)
  {
    //Event creating model
    $this->model->creatingCrudModel(['data' => $data]);

    //Create model
    $model = $this->model->create($data);

    // Default sync model relations
    $model = $this->defaultSyncModelRelations($model, $data);

    // Custom sync model relations
    $model = $this->syncModelRelations($model, $data);

    //Event created model
    $model->createdCrudModel(['data' => $data]);

    //Response
    return $model;
  }

  /**
   * Method to request all data from model
   *
   * @param false $params
   * @return mixed
   */
  public function getItemsBy($params)
  {
    //Instance Query
    $query = $this->model->query();

    //Include relationships
    if (isset($params->include)) $query = $this->includeToQuery($query, $params->include);

    //Filter Query
    if (isset($params->filter)) {
      $filters = $params->filter;//Short data filter
      $modelFillable = array_merge($this->model->getFillable(), ['id', 'created_at', 'updated_at']);//Instance model fillable
      $modelRelations = ($this->model->modelRelations ?? []);//Instance model relations

      //Set fiter order to params.order: TODO: to keep and don't break old version api
      if (isset($filters->order) && isset($params->order) && !$params->order) $params->order = $filters->order;

      //Add Requested Filters
      foreach ($filters as $filterName => $filterValue) {
        $filterNameSnake = camelToSnake($filterName);//Get filter name as snakeCase
        if (!in_array($filterName, $this->replaceFilters)) {
          //Add fillable filter
          if (in_array($filterNameSnake, $modelFillable)) {
            $query = $this->setFilterQuery($query, $filterValue, $filterNameSnake);
          } //Add relation filter
          else if (in_array($filterName, array_keys($modelRelations))) {
            //dd($this->model->$filterName());
            $query = $this->setFilterQuery($query, (object)[
              'where' => $modelRelations[$filterName],
              'table' => $this->model->$filterName()->getTable(),
              'foreignPivotKey' => $this->model->$filterName()->getForeignPivotKeyName(),
              'relatedPivotKey' => $this->model->$filterName()->getRelatedPivotKeyName(),
              'value' => $filterValue
            ], $filterName);
          }
        }
      }

      //Audit filter withTrashed
      if (isset($filters->withTrashed) && $filters->withTrashed) $query->withTrashed();

      //Audit filter onlyTrashed
      if (isset($filters->onlyTrashed) && $filters->onlyTrashed) $query->onlyTrashed();

      //Add model filters
      $query = $this->filterQuery($query, $filters);
    }

    //Order Query
    $query = $this->orderQuery($query, $params->order ?? true);

    //Response as query
    if (isset($params->returnAsQuery) && $params->returnAsQuery) $response = $query;
    //Response paginate
    else if (isset($params->page) && $params->page) $response = $query->paginate($params->take);
    //Response complete
    else {
      if (isset($params->take) && $params->take) $query->take($params->take);//Take
      $response = $query->get();
    }

    //Response
    return $response;
  }

  /**
   * Method to get model by criteria
   *
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function getItem($criteria, $params = false)
  {
    //Instance Query
    $query = $this->model->query();

    //Include relationships
    if (isset($params->include)) $query = $this->includeToQuery($query, $params->include);

    //Check field name to criteria
    if (isset($params->filter->field)) $field = $params->filter->field;

    //Request
    $response = $query->where($field ?? 'id', $criteria)->first();

    //Response
    return $response;
  }

  /**
   * Method to update model by criteria
   *
   * @param $criteria
   * @param $data
   * @param $params
   * @return mixed
   */
  public function updateBy($criteria, $data, $params)
  {
    //Event updating model
    $this->model->updatingCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

    //Instance Query
    $query = $this->model->query();

    //Check field name to criteria
    if (isset($params->filter->field)) $field = $params->filter->field;

    //get model and update
    if ($model = $query->where($field ?? 'id', $criteria)->first()) {
      //Update Model
      $model->update((array)$data);
      // Default Sync model relations
      $model = $this->defaultSyncModelRelations($model, $data);
      // Custom Sync model relations
      $model = $this->syncModelRelations($model, $data);
      //Event updated model
      $model->updatedCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);
    }

    //Response
    return $model;
  }

  /**
   * Method to delete model by criteria
   *
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function deleteBy($criteria, $params)
  {
    //Instance Query
    $query = $this->model->query();

    //Check field name to criteria
    if (isset($params->filter->field)) $field = $params->filter->field;

    //get model
    $model = $query->where($field ?? 'id', $criteria)->first();

    //Delete Model
    if ($model) $model->delete();

    //Response
    return $model;
  }

  /**
   * Method to delete model by criteria
   *
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function restoreBy($criteria, $params)
  {
    //Instance Query
    $query = $this->model->query();

    //Check field name to criteria
    if (isset($params->filter->field)) $field = $params->filter->field;

    //get model
    $model = $query->where($field ?? 'id', $criteria)->withTrashed()->first();

    //Delete Model
    if ($model) $model->restore();

    //Response
    return $model;
  }
}
