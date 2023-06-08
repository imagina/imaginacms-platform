<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Iplaces\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iplaces\Events\CategoryWasCreated;
use Modules\Iplaces\Entities\Category;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter
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
        $query->whereIn('iplaces__categories.id', $ids);
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

      if (isset($filter->tagId)) {
        $query->whereTag($filter->tagId, "id");
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where('id', 'like', '%' . $filter->search . '%')
          ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
          ->orWhere('created_at', 'like', '%' . $filter->search . '%');
      }

      //Parent Id
      if (isset($filter->parentId)) {
        if (is_null($filter->parentId)) {
          $query->whereNull("parent_id");
        } else {
          if (!is_array($filter->parentId)) $filter->parentId = [$filter->parentId];
          $query->whereIn('parent_id', $filter->parentId);
        }
      }
    }

    // ORDER
    if (isset($params->order) && $params->order) {

      $order = is_array($params->order) ? $params->order : [$params->order];

      foreach ($order as $orderObject) {

        if (isset($orderObject->field) && isset($orderObject->way)) {
          if (in_array($orderObject->field, $this->model->translatedAttributes)) {
            $query->join('iplaces__category_translations as translations', 'translations.category_id', 'iplaces__categories.id');
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

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take, ['*'], null, $params->page);
    } else {
      isset($params->take) && $params->take ? $query->take($params->take) : false;//Take

      return $query->get();
    }
  }


  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
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
    $category = $this->model->create($data);
    event(new CategoryWasCreated($category, $data));
    event(new CreateMedia($category, $data));
    return $this->find($category->id);
  }


  public function updateBy($criteria, $data, $params = false)
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
    $model = $query->where($field ?? 'id', $criteria)->first();

    $model ? $model->update((array)$data) : false;
    event(new UpdateMedia($model, $data));
  }

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
