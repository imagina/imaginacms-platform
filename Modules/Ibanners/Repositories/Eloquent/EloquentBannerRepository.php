<?php

namespace Modules\Ibanners\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ibanners\Events\BannerWasCreated;
use Modules\Ibanners\Events\BannerWasDeleted;
use Modules\Ibanners\Events\BannerWasUpdated;
use Modules\Ibanners\Repositories\BannerRepository;

class EloquentBannerRepository extends EloquentBaseRepository implements BannerRepository
{
    /**
     * Override for add the event on create and link media file
     *
     * @param  mixed  $data Data from POST request form
     * @return object The created entity
     */
    public function create($data): object
    {
        $banner = parent::create($data);

        event(new BannerWasCreated($banner, $data));

        return $banner;
    }

    public function update($banner, $data)
    {
        $banner->update($data);
        event(new BannerWasUpdated($banner, $data));

        return $banner;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($model)
    {
        event(new BannerWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }

    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter
            if (isset($filter->position)) {
                $query->where('position_id', $filter->position);
            }
            //Filter by date
            if (isset($filter->date)) {
                $date = $filter->date; //Short filter date
                $date->field = $date->field ?? 'created_at';
                if (isset($date->from)) {//From a date
                    $query->whereDate($date->field, '>=', $date->from);
                }
                if (isset($date->to)) {//to a date
                    $query->whereDate($date->field, '<=', $date->to);
                }
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false; //Take

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
           $includeDefault = []; //Default relationships
           if (isset($params->include)) {//merge relations with default relationships
               $includeDefault = array_merge($includeDefault, $params->include);
           }
           $query->with($includeDefault); //Add Relationships to query
       }

       /*== FILTER ==*/
       if (isset($params->filter)) {
           $filter = $params->filter;

           if (isset($filter->field)) {//Filter by specific field
               $field = $filter->field;
           }
       }

       /*== FIELDS ==*/
       if (isset($params->fields) && count($params->fields)) {
           $query->select($params->fields);
       }

       /*== REQUEST ==*/
       return $query->where($field ?? 'id', $criteria)->first();
   }

    public function deleteBy($criteria, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();
        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;
            if (isset($filter->field)) {//Where field
                $field = $filter->field;
            }
        }
        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();
        $model ? $model->delete() : false;
    }
}
