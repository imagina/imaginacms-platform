<?php

namespace Modules\Ievent\Repositories\Eloquent;

use Modules\Ievent\Entities\Status;
use Modules\Ievent\Events\EventWasCancelled;
use Modules\Ievent\Events\EventWasUpdated;
use Modules\Ievent\Repositories\EventRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Str;
use Modules\Ievent\Events\EventWasCreated;

class EloquentEventRepository extends EloquentBaseRepository implements EventRepository
{
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['files'];//Default relationships
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
        $date->field = $date->field ?? 'date';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      } else {
        $query->whereRaw("date >= '" . date('Y-m-d') . "' and hour >= '" . date('H:i:s') . "'");
      }

      //add filter all Events to square view
      if (isset($params->department->id)) {
        $query->where("department_id", $params->department->id);
      } else {
        //add filter by departments id
        $query->where(function ($query) use ($filter, $params) {
          //$user = $params->user;
          $departments = $params->departments->pluck('id')->toArray();
          $query->where(function ($query) use ($filter, $departments) {
            $query->whereIn('department_id', $departments)
              ->where('is_public', 0);
          })->orWhere('is_public', 1);
        });
      }

      //Department ID
      if (isset($filter->departmentId)) {
        $query->where("department_id", $filter->departmentId);
      }

      //Category ID
      if (isset($filter->categoryId)) {
        $query->where("category_id", $filter->categoryId);
      }

      //Status
      if (isset($filter->status) && !is_null($filter->status)) {
        $query->where("status", $filter->status);
      }

      //Place Category ID
      if (isset($filter->placeCategoryId) && $filter->placeCategoryId) {
        if (!is_array($filter->placeCategoryId)) $filter->placeCategoryId = [$filter->placeCategoryId];
        $query->whereHas('place', function ($query) use ($filter) {
          $query->whereIn("iplaces__places.category_id", $filter->placeCategoryId);
        });
      }

      //Place City ID
      if (isset($filter->placeCityId) && $filter->placeCityId) {
        if (!is_array($filter->placeCityId)) $filter->placeCityId = [$filter->placeCityId];
        $query->whereHas('place', function ($query) use ($filter) {
          $query->whereIn("iplaces__places.city_id", $filter->placeCityId);
        });
      }

      //by Attendants [ids]
      if (isset($filter->attendants) && $filter->attendants) {
        if (!is_array($filter->attendants)) $filter->attendants = [$filter->attendants];
        $query->whereHas('attendants', function ($query) use ($filter) {
          $query->whereIn("ievent__attendants.user_id", $filter->attendants);
        });
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      } else {
        $query->orderByRaw('date, hour');//Add order to query
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('title', 'like', '%' . $filter->search . '%')
            ->orWhere('description', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }


    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    // dd($query->toSql(),$query->getBindings());
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }


  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['place'];//Default relationships
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
    $event = $this->model->create($data);


    if (isset($data["options"]["mainImage"])) {
      $mainImage = $data["options"]["mainImage"];

      if (Str::contains($mainImage, 'data:image/'))
        $data["options"]["mainImage"] = saveImage($mainImage, "assets/ievent/event" . $event->id . ".jpg");
      else {
        $data["options"]["mainImage"] = 'modules/iblog/img/category/default.jpg';
      }
    }

    if (isset($data["options"]["secondaryImage"])) {
      $secondaryImage = $data["options"]["secondaryImage"];

      if (Str::contains($secondaryImage, 'data:image/'))
        $data["options"]["secondaryImage"] = saveImage($secondaryImage, "assets/ievent/event" . $event->id . ".jpg");
      else {
        $data["options"]["secondaryImage"] = url('modules/iblog/img/category/default.jpg');
      }
    }

    $event->update($data);
    event(new EventWasCreated($event));
    return $event;
  }


  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field)) $field = $filter->field;
    }

    //Get model
    $model = $query->where($field ?? 'id', $criteria)->first();
    if ($model) {
      //Validate status
      if (isset($data["status"])) {
        //Check if isn't cancelled
        if (($data["status"] == Status::CANCELLED) && $model->status) {
          event(new EventWasCancelled($model, $params->user));
        } else if ($data["status"] == Status::PUBLISHED) {
          event(new EventWasUpdated($model, $params->user));
        }
      }

      //Update Model
      $model->update((array)$data);
    }

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

    if ($model) {
      $id = $model->id;
      $model->comments()->delete();

      deleteImage(str_replace(env('APP_URL'), '', $model->options->mainImage));
      $model->delete();

    }

  }


}
