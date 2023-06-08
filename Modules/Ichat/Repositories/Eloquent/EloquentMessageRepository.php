<?php

namespace Modules\Ichat\Repositories\Eloquent;

use Modules\Ichat\Events\MessageWasSaved;
use Modules\Ichat\Repositories\MessageRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Support\Facades\Auth;
use Modules\Ichat\Events\MessageWasCreated;
use Modules\Ichat\Events\NewMessageInConversation;
use Modules\Ichat\Events\ConversationUserWasUpdated;
use Modules\Ichat\Events\MessageWasRetrieved;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentMessageRepository extends EloquentBaseRepository implements MessageRepository
{
  public function getItemsBy($params)
  {
    // INITIALIZE QUERY
    $query = $this->model->query();
    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['files']);
    } else {//Especific relationships
      $includeDefault = ['files'];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    // FILTERS
    if ($params->filter) {
      $filter = $params->filter;

      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      // Filter by conversation
      if (isset($filter->conversationId)) {
        $query->where('conversation_id', $filter->conversationId);
      }

      // Filter by user
      if (isset($filter->user)) {
        $query->where('user_id', $filter->user);
      }
    }

    //Order by
    $orderByField = $params->filter->order->field ?? 'created_at';//Default field
    $orderWay = $params->filter->order->way ?? 'desc';//Default way
    $query->orderBy($orderByField, $orderWay);//Add order to query

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      $response = $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      $response = $query->get();
    }

    //Event
    if ($response->count()) {
      event(new MessageWasRetrieved($response->first()));
    }

    //Response
    return $response;
  }

  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['files']);
    } else {//Especific relationships
      $includeDefault = ['files'];//Default relationships
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
    return \DB::transaction(function () use ($data){
    $message = $this->model->create($data);
  
    
    $conversation = $message->conversation;

    $message->conversation()->update(['private'=>$conversation->private]);

    //Event to ADD media
    event(new CreateMedia($message, $data));
    event(new MessageWasSaved($message));
    

    return $message;
    }, 5);
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

      $model->update($data);

      //Event to Update media
      event(new UpdateMedia($model, $data));

      return $model;
    }

    return false;
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

    if(isset($model->id))
      event(new DeleteMedia($model->id, get_class($model)));
  }
}
