<?php

namespace Modules\Iprofile\Repositories\Eloquent;

use Modules\Iprofile\Repositories\RoleApiRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\Iforms\Events\SyncFormeable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentRoleApiRepository extends EloquentBaseRepository implements RoleApiRepository
{
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include ?? [])) {//If Request all relationships
      $query->with(['settings']);
    } else {//Especific relationships
      $includeDefault = ['settings'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*=== SETTINGS ===*/
    if (isset($params->settings)) {
      $settings = $params->settings;
      if (isset($settings['assignedRoles']) && count($settings['assignedRoles'])) {
        $query->whereIn('id', $settings['assignedRoles']);
      }
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

      //Filter by ID
      if(isset($filter->id)){
        $idFilter = is_array($filter->id) ? $filter->id : [$filter->id];
        $query->whereIn('id', $idFilter);
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
        $query->where(function ($query) use ($filter) {
          $query->where('id', 'like', '%' . $filter->search . '%')
            ->orWhere('name', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
        });
      }
    }

    $entitiesWithCentralData = json_decode(setting("iprofile::tenantWithCentralData",null,"[]"));
    $tenantWithCentralData = in_array("roles",$entitiesWithCentralData);

    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->onlyQuery) && $params->onlyQuery) {
      return $query;
    } else
      if (isset($params->page) && $params->page) {
        //return $query->paginate($params->take);
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
      $query->with(['settings']);
    } else {//Especific relationships
      $includeDefault = ['settings'];//Default relationships
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

    $entitiesWithCentralData = json_decode(setting("iprofile::tenantWithCentralData",null,"[]"));
    $tenantWithCentralData = in_array("roles",$entitiesWithCentralData);

    if ($tenantWithCentralData && isset(tenant()->id)) {
      $model = $this->model;

      $query->withoutTenancy();
      $query->where(function ($query) use ($model) {
        $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
          ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
      });
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
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
  
      event(new SyncFormeable($model,$data));
      
      $newData = $model->toArray();
    }
    return $model;
  }

  public function create($data)
  {
    $role = $this->model->create($data);
    
    event(new SyncFormeable($role,$data));
    
    return $role;
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

}
