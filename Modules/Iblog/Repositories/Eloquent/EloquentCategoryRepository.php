<?php

namespace Modules\Iblog\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Events\CategoryWasCreated;
use Modules\Iblog\Events\CategoryWasDeleted;
use Modules\Iblog\Events\CategoryWasUpdated;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

  /**
   * @inheritdoc
   */
  public function find($id)
  {
    if (method_exists($this->model, 'translations')) {
      return $this->model->with('translations')->find($id);
    }
    return $this->model->with('parent', 'children')->find($id);
  }

  /**
   * Find a resource by the given slug
   *
   * @param string $slug
   * @return object
   */
  public function findBySlug($slug)
  {
    if (method_exists($this->model, 'translations')) {
      return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
        $q->where('slug', $slug);
      })->with('translations', 'parent', 'children', 'posts')->firstOrFail();
    }

    return $this->model->where('slug', $slug)->with('translations', 'parent', 'children', 'posts')->first();
  }

  /**
   * Standard Api Method
   * @param bool $params
   * @return mixed
   */
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['translations', 'files']);
    } else {//Especific relationships
      $includeDefault = ['translations', 'files'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include ?? []);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter
      if (isset($filter->parent)) {
        $query->where('parent_id', $filter->parent);
      }


      if (isset($filter->id)) {
        !is_array($filter->id) ? $filter->id = [$filter->id] : false;
        $query->whereIn('id', $filter->id);
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


      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }
      if (is_module_enabled('Marketplace')) {
        if (isset($filter->store)) {
          $query->where('store_id', $filter->store);
        }
      }
      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      //internal
      if (isset($filter->internal)) {
        $query->where("internal", $filter->internal);//Add order to query
      }
    }


    // ORDER
    if (isset($params->order) && $params->order) {

      $order = is_array($params->order) ? $params->order : [$params->order];

      foreach ($order as $orderObject) {

        if (isset($orderObject->field) && isset($orderObject->way)) {
          if (in_array($orderObject->field, $this->model->translatedAttributes)) {
            $query->join('iblog__category_translations as translations', 'translations.category_id', '=', 'iblog__categories.id');
            $query->orderBy("translations.$orderObject->field", $orderObject->way);
          } else
            $query->orderBy($orderObject->field, $orderObject->way);
        }

      }
    } else {
      $query->orderBy('sort_order', 'asc');//Add order to query
    }


    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);


    if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {

    } else {

      //pre-filter status
      $query->where("status", 1);
    }


    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      // dd($query->toSql(),$query->getBindings(),$query->get(), $params);
      return $query->paginate($params->take);
    } else {
      isset($params->take) && $params->take ? $query->take($params->take) : false;//Take

      // dd($query->toSql(),$query->getBindings(),$query->get(), $params);
      return $query->get();
    }
  }

  /**
   * Standard Api Method
   * @param $criteria
   * @param bool $params
   * @return mixed
   */
  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['translations']);
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

      // find translatable attributes
      $translatedAttributes = $this->model->translatedAttributes;

      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale ?? \App::getLocale())
            ->where($field, $criteria);
        });
      else
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->first();
  }

  /**
   * Standard Api Method
   * @param $data
   * @return mixed
   */
  public function create($data)
  {
    //Event creating model
    if (method_exists($this->model, 'creatingCrudModel'))
      $this->model->creatingCrudModel(['data' => $data]);

    $category = $this->model->create($data);

    //Event created model
    if (method_exists($category, 'createdCrudModel'))
      $category->createdCrudModel(['data' => $data]);

    event(new CategoryWasCreated($category, $data));

    return $this->find($category->id);
  }

  /**
   * Update a resource
   * @param $category
   * @param array $data
   * @return mixed
   */
  public function update($category, $data)
  {


    $category->update($data);


    event(new CategoryWasUpdated($category, $data));

    return $category;
  }


  public function destroy($model)
  {
    event(new CategoryWasDeleted($model->id, get_class($model)));

    return $model->delete();
  }


  /**
   * Standard Api Method
   * @param $criteria
   * @param $data
   * @param bool $params
   * @return bool
   */
  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    //Event updating model
    if (method_exists($this->model, 'updatingCrudModel'))
      $this->model->updatingCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();

    if (isset($model->id)) {
      $model->update((array)$data);
      //Event updated model
      if (method_exists($model, 'updatedCrudModel'))
        $model->updatedCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

      event(new UpdateMedia($model, $data));
    }


  }

  /**
   * Standard Api Method
   * @param $criteria
   * @param bool $params
   */
  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    $model ? $model->delete() : false;
    event(new DeleteMedia($model->id, get_class($model)));

  }


}
