<?php

namespace Modules\Iblog\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Events\CategoryWasCreated;
use Modules\Iblog\Events\CategoryWasDeleted;
use Modules\Iblog\Events\CategoryWasUpdated;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentCategoryRepository extends EloquentCrudRepository implements CategoryRepository
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
  
    if (isset($filter->id)) {
      $ids = is_array($filter->id) ? $filter->id : [$filter->id];
    
      if (isset($filter->includeDescendants) && $filter->includeDescendants) {
        foreach ($ids as $id) {
          if (isset($filter->includeSelf) && $filter->includeSelf) {
            $categories = Category::descendantsAndSelf($id);
          } else {
            $categories = Category::descendantsOf($id);
          }
          $ids = array_merge($ids, $categories->pluck("id")->toArray());
        }
      }
    
      $query->whereIn('id', $ids);
    }
  
    if (isset($filter->parentId)) {
    
      !is_array($filter->parentId) ? $filter->parentId = [$filter->parentId] : false;
      $ids = [];
      foreach ($filter->parentId as $parentId) {
        if (isset($filter->includeDescendants) && $filter->includeDescendants) {
          if (isset($filter->includeSelf) && $filter->includeSelf)
            $categories = Category::descendantsAndSelf($parentId);
          else
            $categories = Category::descendantsOf($parentId);
        } else {
          $categories = $this->model->query()->where("parent_id", $parentId)->get();
        }
      
        $ids = array_merge($ids, $categories->pluck("id")->toArray());
      }
      $query->whereIn('iblog__categories.id', $ids);
    }
  
    if (isset($filter->search)) { //si hay que filtrar por rango de precio
      $criterion = $filter->search;
      $param = explode(' ', $criterion);
      $criterion = $filter->search;
      //find search in columns
      $query->where(function ($query) use ($filter, $criterion) {
        $query->whereHas('translations', function (Builder $q) use ($criterion) {
          $q->where('title', 'like', "%{$criterion}%");
        });
      })->orWhere('id', 'like', '%' . $filter->search . '%');
    }
  
    if (isset($filter->tagId)) {
    
      $query->whereTag($filter->tagId, "id");
    
    
    }
  
  
    //add filter by showMenu
    if (isset($filter->showMenu) && is_bool($filter->showMenu)) {
      $query->where('show_menu', $filter->showMenu);
    }
  
    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
    
    } else {
    
      //pre-filter status
      $query->whereRaw("iblog__categories.id IN (SELECT category_id from iblog__category_translations where status = 1)");
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
  
  /**
   * Method to include relations to query
   * @param $query
   * @param $relations
   */
  public function includeToQuery($query, $relations)
  {
    
    //request all categories instances in the "relations" attribute in the entity model
    if (in_array('*', $relations)) $relations = $this->model->getRelations() ?? ['files','translations'];
    //Instance relations in query
    $query->with($relations);
    //Response
    return $query;
  }


}
