<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\FieldRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentFieldRepository extends EloquentBaseRepository implements FieldRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
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

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //By User ID
      if (isset($filter->userId)) {
        $query->where('user_id', $filter->userId);
      }

      //By Name
      if (isset($filter->name)) {
        $query->where('name', $filter->name);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

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
    //find if exist with the same name
    $model = $this->findByAttributes(["name" => $data["name"], 'user_id' => $data["user_id"]]);

    if (!$model) {
      $field = $this->model->create($data);
      $newData = $field->toArray();
      return $field;
    } else {
      return $this->updateBy($model->id, $data, (object)["filter" => (object)["field" => "id"]]);
    }
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

    if ($model) {
      $oldData = $model->toArray();
      $model->update($data);
      $newData = $model->toArray();
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
      $oldData = $model->toArray();
      $model->delete();

    }
  }

  //Get users birthday
  public function usersBirthday($params)
  {
    $birthdayFields = $this->model->where('name', 'birthday')->get();
    $futureBirthdayUsersId = [];
    $response = [];

    //Get future birthdays
    foreach ($birthdayFields as $field) {
      if (date("m", strtotime($field->value)) >= date('m'))
        $futureBirthdayUsersId[] = $field->user_id;
    }

    //Get data user
    $usersData = \DB::table('users')->whereIn('id', $futureBirthdayUsersId)->get();

    //Transform data
    foreach ($usersData as $user) {
      $response[] = collect([
        'id' => $user->id,
        'firstName' => $user->first_name,
        'lastName' => $user->last_name,
        'fullName' => "{$user->first_name} {$user->last_name}",
        'birthday' => date(
          date('Y') . "-m-d 12:00:00",
          strtotime($birthdayFields->where('user_id', $user->id)->pluck('value')->first())
        )
      ]);
    }

    //Response
    return $response;
  }
}
