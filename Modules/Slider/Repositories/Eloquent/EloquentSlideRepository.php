<?php namespace Modules\Slider\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Slider\Events\SlideWasCreated;

class EloquentSlideRepository extends EloquentBaseRepository implements SlideRepository
{

    /**
     * Override for add the event on create and link media file
     *
     * @param mixed $data Data from POST request form
     *
     * @return object The created entity
     */
    public function create($data)
    {
        $slide = parent::create($data);

        event(new SlideWasCreated($slide, $data));

        return $slide;
    }

    public function update($sliderItem, $data)
    {
        $sliderItem->update($data);

        return $sliderItem;
    }
  
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();
    
    /*== RELATIONSHIPS ==*/
    if(in_array('*',$params->include)){//If Request all relationships
      $query->with([]);
    }else{//Especific relationships
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
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take ?? 12, ['*'], null, $params->page);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }

}
