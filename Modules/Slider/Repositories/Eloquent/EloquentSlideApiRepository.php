<?php namespace Modules\Slider\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Repositories\SlideApiRepository;
use Modules\Slider\Events\SlideWasCreated;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentSlideApiRepository extends EloquentBaseRepository implements SlideApiRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (isset($params->include) && in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['translations', 'files']);
    } else {//Especific relationships
      $includeDefault = ['translations', 'files'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

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

      //Filter by id
      if (isset($filter->sliderId)) {
        $query->where('slider_id', $filter->sliderId);
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }

      if (isset($filter->id)) {
        !is_array($filter->id) ? $filter->id = [$filter->id] : false;
        $query->where('id', $filter->id);
      }
    }

    $entitiesWithCentralData = json_decode(setting("isite::tenantWithCentralData", null, "[]", true));
    $tenantWithCentralData = in_array("slide", $entitiesWithCentralData);

    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }

    // ORDER
    if (isset($params->order) && $params->order) {

      $order = is_array($params->order) ? $params->order : [$params->order];

      foreach ($order as $orderObject) {
        if (isset($orderObject->field) && isset($orderObject->way)) {
          if (in_array($orderObject->field, $this->model->translatedAttributes)) {
            $query->join('slider__slide_translations as translations', 'translations.slide_id', '=', 'slider__slides.id');
            $query->orderBy("translations.$orderObject->field", $orderObject->way);
          } else
            $query->orderBy($orderObject->field, $orderObject->way);
        }

      }
    } else {
      //Order by "Sort order"
      if (!isset($filter->search) && !isset($params->filter->order) && (!isset($params->filter->noSortOrder) || !$params->filter->noSortOrder)) {
        $query->orderBy('position', 'asc');//Add order to query
      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      //return $query->paginate($params->take);
      return $query->paginate($params->take, ['*'], null, $params->page);
    } else {
      isset($params->take) && $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }

  public function index($page, $take, $filter, $include){
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $query->with(array_merge($includeDefault, $include));
    }

    /*== FILTER ==*/
    if ($filter) {
      //Filter by id
      if (isset($filter->sliderId)) {
        $query->where('slider_id', $filter->sliderId);
      }
    }

    /*=== REQUEST ===*/
    if ($page) {//Return request with pagination
      $take ? true : $take = 12; //If no specific take, query default take is 12
      return $query->paginate($take);
    } else {//Return request without pagination
      $take ? $query->take($take) : false; //Set parameter take(limit) if is requesting
      return $query->get();
    }
  }

  public function show($id, $include)
  {
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $query->with(array_merge($includeDefault, $include));
    }

    $query->where('id', $id);

    /*=== REQUEST ===*/
    return $query->first();
  }

  public function create($data)
  {
    $model = $this->model->create($data);
    event(new CreateMedia($model, (array)$data));

    return $model;
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

    //Event to Update media
    event(new UpdateMedia($model, (array)$data));
    return $model;
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

}
