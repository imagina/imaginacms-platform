<?php

namespace Modules\Iappointment\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iappointment\Events\AppointmentIsCreating;
use Modules\Iappointment\Events\AppointmentStatusWasUpdated;
use Modules\Iappointment\Events\AppointmentWasCreated;
use Modules\Iappointment\Events\AppointmentWasUpdated;
use Modules\Iappointment\Repositories\AppointmentRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentAppointmentRepository extends EloquentBaseRepository implements AppointmentRepository
{
    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function getItemsBy(bool $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
            }

            if (! is_module_enabled('Ichat')) {
                $key = array_search('conversation', $includeDefault);
                unset($includeDefault[$key]);
            }

            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter
            if (isset($filter->category)) {
                $query->where('category_id', $filter->category);
            }

            if (isset($filter->status)) {
                $query->where('status_id', $filter->status);
            }

            if (isset($filter->customer)) {
                $query->where('customer_id', $filter->customer);
            }

            if (isset($filter->assigned)) {
                $query->where('assigned_to', $filter->assigned);
            }

            if (isset($filter->search)) { //si hay que filtrar por rango de precio
                $criterion = $filter->search;
                $param = explode(' ', $criterion);
                $criterion = $filter->search;
                //find search in columns
                $query->where(function ($query) use ($criterion) {
                    $query->whereHas('translations', function (Builder $q) use ($criterion) {
                        $q->where('description', 'like', "%{$criterion}%");
                    });
                })->orWhere('id', 'like', '%'.$filter->search.'%');
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

            if (isset($filter->ids)) {
                is_array($filter->ids) ? true : $filter->ids = [$filter->ids];
                $query->whereIn('iappointment__appointments.id', $filter->ids);
            }
            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }
        }

        $this->validateIndexAllPermission($query, $params);

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

    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function getItem($criteria, bool $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
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

            // find translatable attributes
            $translatedAttributes = $this->model->translatedAttributes;

      // filter by translatable attributes
            if (isset($field) && in_array($field, $translatedAttributes)) {//Filter by slug
                $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
                    $query->where('locale', $filter->locale)
                      ->where($field, $criteria);
                });
            } else {
                // find by specific attribute or by id
                $query->where($field ?? 'id', $criteria);
            }
        } else {
            $query->where($field ?? 'id', $criteria);
        }

        $this->validateIndexAllPermission($query, $params);

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        return $query->first();
    }

    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function create($data)
    {
        event(new AppointmentIsCreating($data));

        $model = $this->model->create($data);

        event(new AppointmentWasCreated($model));

        event(new CreateMedia($model, $data));

        return $this->find($model->id);
    }

    /**
     * Standard Api Method
     */
    public function updateBy($criteria, $data, bool $params = false): bool
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== FILTER ==*/
        if (isset($params->filter)) {
            $filter = $params->filter;

            //Update by field
            if (isset($filter->field)) {
                $field = $filter->field;
            }
        }

        /*== REQUEST ==*/
        $model = $query->where($field ?? 'id', $criteria)->first();

        $modelStatus = $model->status_id;

        $model->update((array) $data);

        if (isset($data['status_id']) && $modelStatus != $data['status_id']) {
            event(new AppointmentStatusWasUpdated($model, $data));
        }

        if (isset($data['assigned_to']) && $model->assigned_to != $data['assigned_to']) {
            $model->assignedHistory()->attach($data['assigned_to']);
        }

        event(new AppointmentWasUpdated($model));

        event(new UpdateMedia($model, $data));
    }

    /**
     * Standard Api Method
     */
    public function deleteBy($criteria, bool $params = false)
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
        event(new DeleteMedia($model->id, get_class($model)));
    }

    public function validateIndexAllPermission(&$query, $params)
    {
        // filter by permission: index all appointments
        if (! isset($params->permissions['iappointment.appointments.index-all']) ||
          (isset($params->permissions['iappointment.appointments.index-all']) &&
            ! $params->permissions['iappointment.appointments.index-all'])) {
            $user = $params->user ?? null;

            if (isset($user->id)) {
                // if is salesman or salesman manager or salesman sub manager
                $query->where(function ($q) use ($user) {
                    $q->where('customer_id', $user->id)
                      ->orWhere('assigned_to', $user->id);
                });
            }
        }
    }
}
