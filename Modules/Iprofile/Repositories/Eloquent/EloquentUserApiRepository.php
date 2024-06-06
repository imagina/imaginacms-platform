<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class EloquentUserApiRepository extends EloquentBaseRepository implements UserApiRepository
{

  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//specific relationships
      $includeDefault = ['fields','settings'];//Default relationships
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
      } else {
        $query->orderByRaw('first_name ASC, last_name ASC');//Add order to query
      }
      //Filter by enables users
      if (isset($filter->status) && ((int)$filter->status == 1)) {
        $query->whereIn('users.id', function ($query) use ($filter) {
          $query->select('activations.user_id')
            ->from('activations')
            ->where('activations.completed', $filter->status);
        });
      }

      //Filter by disabled users
      if (isset($filter->status) && ((int)$filter->status == 0)) {
        $query->whereNotIn('users.id', function ($query) use ($filter) {
          $query->select('activations.user_id')
            ->from('activations')
            ->where('activations.completed', 1);
        });
      }

      //Filter by user ID
      if (isset($filter->userId) && count($filter->userId)) {
        $query->whereIn('users.id', $filter->userId);
      }

      //filter by department
      if (isset($filter->departmentId) && ((int)$filter->departmentId) != 0) {
        $query->whereIn('users.id', function ($query) use ($filter) {
          $query->select('user_id')
            ->from('iprofile__user_department')
            ->where('department_id', $filter->departmentId);
        });
      }

      //filter by Role ID
      if (isset($filter->roleId) && ((int)$filter->roleId) != 0) {
        $query->whereIn('id', function ($query) use ($filter) {
          $query->select('user_id')->from('role_users')->where('role_id', $filter->roleId);
        });
      }

      //filter by Role Slug
      if (isset($filter->roleSlug)) {
        $query->whereIn('id', function ($query) use ($filter) {
          $query->select('user_id')->from('role_users')->where('role_id', function ($subQuery) use ($filter) {
            $subQuery->select('id')->from('roles')->where('slug', $filter->roleSlug);
          });
        });
      }

      //filter by Roles
      if (isset($filter->roles) && count($filter->roles)) {
        $query->whereIn('id', function ($query) use ($filter) {
          $query->select('user_id')->from('role_users')->whereIn('role_id', $filter->roles);
        });
      }

      //add filter by search
      if (!empty($filter->search)) {
        //find search in columns Customer_name and Customer_Last_Name
        $query->where(function ($query) use ($filter) {
          $query->where('users.id', 'like', '%' . $filter->search . '%')
            ->orWhere('first_name', 'like', '%' . $filter->search . '%')
            ->orWhereRaw('CONCAT(first_name,\' \',last_name) like ?', ['%' . $filter->search . '%'])
            ->orWhere('last_name', 'like', '%' . $filter->search . '%')
            ->orWhere('email', 'like', '%' . $filter->search . '%')
            ->orWhereHas('fields', function ($query) use ($filter) {
              $query->where("name", 'slug');
              $query->where("value", 'like', '%' . $filter->search . '%');
            })
            ->orWhereHas('roles', function ($query) use ($filter) {
              $query->where("roles.name", 'like', '%' . $filter->search . '%');
            });
        });
      }
    }

    //Filter by department selected
    if (isset($filter->getUsersByDepartment)) {
      $query->whereIn('id', $params->usersByDepartment);
    } else

      /*=== SETTINGS ===*/
      if (isset($params->settings)) {
        if (isset($params->settings['assignedRoles']) && !empty($params->settings['assignedRoles'])) {
          $assignedRoles = $params->settings['assignedRoles'];
          $superRoles = array_diff([1, 17], $assignedRoles);
          $query->whereNotIn('id', function ($query) use ($superRoles) {
            $query->select('user_id')->from('role_users')->whereIn('role_id', $superRoles);
          })->whereIn('id', function ($query) use ($assignedRoles) {
            $query->select('user_id')->from('role_users')->whereIn('role_id', $assignedRoles);
          });

        }
      }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      if (in_array('full_name', $params->fields)) {
        $params->fields = array_diff($params->fields, ['full_name']);
        $query->select($params->fields);
        $query->addSelect(\DB::raw('CONCAT(users.first_name,\' \',users.last_name) as full_name'));
      } else
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
    if (isset($params->include) && in_array('*', $params->include)) {//If Request all relationships
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

    /*=== SETTINGS ===*/
    if (isset($params->settings)) {
      if (isset($params->settings['assignedRoles']) && !empty($params->settings['assignedRoles'])) {
        $assignedRoles = $params->settings['assignedRoles'];
        $superRoles = array_diff([1, 17], $assignedRoles);
        $query->whereNotIn('id', function ($query) use ($superRoles) {
          $query->select('user_id')->from('role_users')->whereIn('role_id', $superRoles);
        })->whereIn('id', function ($query) use ($assignedRoles, $criteria) {
          $query->select('user_id')->from('role_users')
            ->whereIn('role_id', $assignedRoles)
            ->orWhere('user_id', $criteria);
        });

      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields)) {
      $params->fields = array_diff($params->fields, ['full_name']);
      $query->select($params->fields);
      $query->addSelect(\DB::raw('CONCAT(users.first_name,\' \',users.last_name) as full_name'));
    }

    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
  }

  public function create($data)
  {
    $model = $this->model->find($data);

    if ($model) {
      // sync tables
      $model->departments()->sync(Arr::get($data, 'departments', []));


    }

    return $model;
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
      $model->update((array)$data);
      $newData = $model->toArray();
      // sync tables
      $model->departments()->sync(Arr::get($data, 'departments', []));

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

  /**
   * Activate User
   *
   * @param $user
   */
  public function activateUser($user)
  {
    $activation = Activation::create($user);
    Activation::complete($user, $activation->code);
  }

  /**
   * Disable User
   *
   * @param $user
   */
  public function disableUser($user)
  {
    \DB::table('activations')->where('user_id', $user->id)->delete();
  }
}
