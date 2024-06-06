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

class EloquentSlideApiRepository extends EloquentBaseRepository implements SlideApiRepository
{
  public function index ($page, $take, $filter, $include){
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
      //Filter by slug
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

  public function show($id,$include){
    //Initialize Query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (count($include)) {
      //Include relationships for default
      $includeDefault = [];
      $query->with(array_merge($includeDefault, $include));
    }

    $query->where('id',$id);

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
          event(new UpdateMedia($model,(array)$data));
          return $model ;
        }
        
}
