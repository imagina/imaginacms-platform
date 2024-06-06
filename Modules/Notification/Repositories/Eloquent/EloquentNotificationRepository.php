<?php

namespace Modules\Notification\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Notification\Repositories\NotificationRepository;

final class EloquentNotificationRepository extends EloquentBaseRepository implements NotificationRepository
{
  /**
   * @param int $userId
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function latestForUser($userId)
  {
    return $this->model->whereUserId($userId)->whereIsRead(false)->orderBy('created_at', 'desc')->take(10)->get();
  }
  
  /**
   * Mark the given notification id as "read"
   * @param int $notificationId
   * @return bool
   */
  public function markNotificationAsRead($notificationId)
  {
    $notification = $this->find($notificationId);
    $notification->is_read = true;
    
    return $notification->save();
  }
  
  public function all()
  {
    return $this->model->all();
  }
  
  public function find($id)
  {
    return $this->model->find($id);
  }
  
  /**
   * Get all the notifications for the given user id
   * @param int $userId
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function allForUser($userId)
  {
    return $this->model->whereUserId($userId)->orWhere('user_id', 0)->orderBy('created_at', 'desc')->get();
  }
  
  /**
   * Get all the read notifications for the given user id
   * @param int $userId
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function allReadForUser($userId)
  {
    return $this->model->whereUserId($userId)->whereIsRead(true)->orderBy('created_at', 'desc')->get();
  }
  
  /**
   * Get all the unread notifications for the given user id
   * @param int $userId
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function allUnreadForUser($userId)
  {
    return $this->model->whereUserId($userId)->whereIsRead(false)->orderBy('created_at', 'desc')->get();
  }
  
  /**
   * Delete all the notifications for the given user
   * @param int $userId
   * @return bool
   */
  public function deleteAllForUser($userId)
  {
    return $this->model->whereUserId($userId)->delete();
  }
  
  /**
   * Mark all the notifications for the given user as read
   * @param int $userId
   * @return bool
   */
  public function markAllAsReadForUser($userId)
  {
    return $this->model->whereUserId($userId)->update(['is_read' => true]);
  }
  
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = ['user'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter
      
      if (isset($filter->read)) {
        $query->whereIsRead($filter->read);
      }
      if (isset($filter->me) || isset($filter->user)) {
        if (isset($filter->me)) {
          if ($filter->me) {
            $query->where(function ($query) use ($params) {
              $query->where('recipient', $params->user->id);
              $query->orWhere('recipient', 0);
            });
          } else {
            $query->where('recipient', 0);
          }
        }
        if (isset($filter->user)) {
          if ($params->user->hasAccess('notification.notifications.manage')) {
            $query->where('recipient', 0);
          } else {
            $query->whereUserId($filter->user);
          }
        }
      } else {
        $query->where('recipient', 0);
      }
      
      if (isset($filter->icon) && !empty($filter->icon)) {
        $query->where('icon_class', 'like', $filter->icon);
      }
  
   
      if(isset($filter->type) && !empty($filter->icon)){
        $query->where('icon_class','like',$filter->icon);
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
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      } else {
        $query->orderBy('created_at', 'desc');
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
  
  public
  function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['user']);
    } else {//Especific relationships
      $includeDefault = ['user'];//Default relationships
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
  
  
  public
  function updateItems($criterias, $data)
  {
    $query = $this->model->query();
    $query->whereIn('id', $criterias)->update($data);
    return $query;
    
    
  }
  
  public
  function deleteItems($criterias)
  {
    $query = $this->model->query();
    
    $query->whereIn('id', $criterias)->delete();
    
    return $query;
    
  }
  
  
}
