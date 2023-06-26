<?php

namespace Modules\Iappointment\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Iappointment\Entities\Appointment;
use Modules\Iappointment\Events\AppointmentStatusWasUpdated;
use Modules\Iappointment\Repositories\AppointmentLeadRepository;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentAppointmentLeadRepository extends EloquentBaseRepository implements AppointmentLeadRepository
{
    /**
     * Standard Api Method
     *
     * @param  bool  $params
     * @return mixed
     */
    public function getItemsBy(bool $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with(['translations']);
        } else {//Especific relationships
            $includeDefault = ['translations']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter
            if (isset($filter->appointment)) {
                $query->where('appointment_id', $filter->appointment);
            }

            if (isset($filter->search)) { //si hay que filtrar por rango de precio
                $criterion = $filter->search;
                $param = explode(' ', $criterion);
                $criterion = $filter->search;
                //find search in columns
                $query->where('value', $filter->search)->orWhere('value', $filter->search)->orWhere('id', 'like', '%'.$filter->search.'%');
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
     * @param  bool  $params
     * @return mixed
     */
    public function getItem($criteria, bool $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
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

            $query->where($field ?? 'id', $criteria);
        }

        if (! isset($params->filter->field)) {
            $query->where('id', $criteria);
        }

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
        $appointmentId = $data['appointment_id'] ?? null;

        if (! empty($appointmentId)) {
            unset($data['appointment_id']);
            foreach ($data as $key => $value) {
                $field = $this->model->where('name', $key)->where('appointment_id', $appointmentId)->first();

                if (isset($field->id)) {
                    $field->value = $value;
                    $field->save();
                } else {
                    $saveField = true;

                    // Fix bug with empty array
                    if (is_array($value) && count($value) === 0) {
                        $saveField = false;
                    }

                    if ($saveField) {
                        $model = $this->model->create([
                            'appointment_id' => $appointmentId,
                            'name' => $key,
                            'value' => $value,
                        ]);
                    }
                }
            }

            $appointment = Appointment::find($appointmentId);

            if ($appointment->status_id == 2) {
                $appointment->status_id = 3;
                $appointment->save();
                event(new AppointmentStatusWasUpdated($appointment, ['status_id' => 3, 'status_comment' => 'Appointment Preform was completed', 'assigned_to' => $appointment->assigned_to]));
            }
        }
    }

    /**
     * Standard Api Method
     *
     * @param  bool  $params
     * @return bool
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

        $model ? $model->update((array) $data) : false;

        event(new UpdateMedia($model, $data));
    }

    /**
     * Standard Api Method
     *
     * @param  bool  $params
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
