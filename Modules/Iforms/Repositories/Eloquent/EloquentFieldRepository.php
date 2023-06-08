<?php

namespace Modules\Iforms\Repositories\Eloquent;

use Modules\Iforms\Repositories\FieldRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

use Modules\Iforms\Entities\Type;

class EloquentFieldRepository extends EloquentBaseRepository implements FieldRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }
    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;
      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query->where('locale', $filter->locale)
              ->where('label', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
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
        $orderByField = $filter->order->field ?? 'order';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      //Filter by parent ID
      if (isset($filter->formId) && !empty($filter->formId)) {
        $query->where("form_id", $filter->formId);
      }

      //Filter by parent ID
      if (isset($filter->parentId) && !empty($filter->parentId)) {
        $query->where("parent_id", $filter->parentId);
      }

      //Filter by type ID
      if (isset($filter->typeId) && !empty($filter->typeId)) {
        $query->where("type", $filter->typeId);
      }

      //Filter by type
      if (isset($filter->type) && !empty($filter->type)) {

        $type = new Type();
        $typeId = $type->getIdByValue($filter->type);

        if (!is_null($typeId))
          $query->where("type", $typeId);
        else
          throw new \Exception('Type not found', 404);

      }

      if (isset($filter->id)) {
        !is_array($filter->id) ? $filter->id = [$filter->id] : false;
        $query->where('id', $filter->id);
      }

    }
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }

  public function getItem($criteria, $params = false)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['translations'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }
    /*== FIELDS ==*/
    if (isset($params->fields) && is_array($params->fields) && count($params->fields))
      $query->select($params->fields);
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
          $query->where('locale', $filter->locale)
            ->where($field, $criteria);
        });
      else
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);
    }

    if (!isset($params->filter->field)) {
      $query->where('id', $criteria);
    }

    /*== REQUEST ==*/
    return $query->first();
  }

  public function create($data)
  {
    $category = $this->model->create($data);
    return $category;
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
    return $model ? $model->update((array)$data) : false;
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
  }

  public function updateOrders($data)
  {
    $fields = [];
    foreach ($data as $field) {
      $fields[] = $this->model->find($field['id'])->update($field);
    }
    return $fields;
  }
}
