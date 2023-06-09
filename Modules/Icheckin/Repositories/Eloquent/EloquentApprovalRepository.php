<?php

namespace Modules\Icheckin\Repositories\Eloquent;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Icheckin\Entities\Approvals;
use Modules\Icheckin\Entities\Shift;
use Modules\Icheckin\Repositories\ApprovalRepository;
use Modules\Icheckin\Transformers\ByShiftsReportTransformer;

class EloquentApprovalRepository extends EloquentBaseRepository implements ApprovalRepository
{
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

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->where('id', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
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

    public function getItemsWithShifts($params = false)
    {
        $filter = $params->filter;

        $approvals = $this->model->selectRaw('
      id as approval_id, approved_by, period_approved, user_id, DATE_FORMAT(date,"%Y/%m/%d") as date
      ')
          ->whereDate('date', '>=', date('Y-m-d', strtotime($filter->date->from)))
          ->whereDate('date', '<=', date('Y-m-d', strtotime($filter->date->to)))
          ->get();

        //   \DB::enableQueryLog(); // Enable query log
        $query = \DB::table('users as u')->selectRaw("
       u.id as checkin_by,
      CASE WHEN s.shifts THEN s.shifts ELSE 0 END as shifts,
      CASE WHEN `s`.`approval_id` THEN 'approved' ELSE '' END as approved,
      s.total_period_elapsed,
      CASE WHEN s.approval_id THEN s.total_period_elapsed ELSE 0 END as period_approved,
      s.date as date_for_approve,
      s.approval_id,
      s.approval_id as approved_by
      ")->leftJoin(\DB::raw('(
      SELECT COUNT(sSub.id) as shifts, SUM(sSub.period_elapsed) as total_period_elapsed, sSub.checkin_by, DATE_FORMAT(sSub.checkin_at,"%Y/%m/%d")as date, sSub.approval_id
        from icheckin__shifts as sSub
        where `sSub`.`checkin_at` >= "'.$filter->date->from.'"
        and `sSub`.`checkin_at` <= "'.$filter->date->to.'"
        group by sSub.checkin_by, DATE_FORMAT(sSub.checkin_at,"%Y/%m/%d"),sSub.approval_id) as s'),
            function ($join) {
                $join->on('u.id', 's.checkin_by');
            });

        if (isset($params->filter)) {
            //dd($query->toSql(),$query->getBindings());
            $filter = $params->filter;
            if (isset($filter->repId) && $filter->repId) {
                $query->where('u.id', $filter->repId);
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->where('u.id', 'like', '%'.$filter->search.'%')
                      ->orWhere('u.first_name', 'like', '%'.$filter->search.'%')
                      ->orWhere('u.last_name', 'like', '%'.$filter->search.'%');
                });
            }

            if (! isset($params->permissions['icheckin.shifts.index-all']) || ! $params->permissions['icheckin.shifts.index-all']) {
                $query->where('u.id', $params->user->id);
            } else {
                $query->whereIn('u.id', $filter->usersByDepartment);
            }
            /*
            if(!isset($params->permissions["icheckin.shifts.checkin"]) || !$params->permissions["icheckin.shifts.checkin"]){
              $query->whereNotIn("u.id",[$params->user->id]);
            }*/
        }

        $shifts = $query->get();

        foreach ($shifts as &$shift) {
            if (! $shift->approval_id) {
                $approval = $approvals->where('user_id', $shift->checkin_by)->first();
                if ($approval) {
                    $shift->date_for_approve = $approval->date;
                    $shift->period_approved = $approval->period_approved;
                    $shift->approved_by = $approval->approved_by;
                    $shift->approval_id = $approval->approval_id;
                }
            }
        }

        foreach ($shifts as &$shift) {
            $approval = $approvals
              ->where('user_id', $shift->checkin_by)
              ->where('date', $shift->date_for_approve)->first();

            if ($approval) {
                $shift->date_for_approve = $approval->date;
                $shift->period_approved = $approval->period_approved;
                $shift->approved_by = $approval->approved_by;
                if ($shift->approval_id != $approval->approval_id) {
                    $shift->approval_id = $approval->approval_id;
                }
            }

            $appvals = $approvals->filter(function ($aprvl, $key) use ($shift, $shifts) {
                return $aprvl->user_id == $shift->checkin_by && ! in_array($aprvl->date, $shifts->pluck('date_for_approve')->toArray());
            })->all();

            foreach ($appvals as $a) {
                $shifts->push((object) [
                    'checkin_by' => $a->user_id,
                    'shifts' => 0,
                    'approved' => 'approved',
                    'total_period_elapsed' => null,
                    'period_approved' => $a->period_approved,
                    'date_for_approve' => $a->date,
                    'approval_id' => $a->approval_id,
                    'approved_by' => $a->approved_by,
                ]);
            }
        }

        return $shifts;
        //$query->get();
        // \Log::info(\DB::getQueryLog()); // Show results of log
        //return $query->toSql();
        //dd($query->toSql(),$query->getBindings());
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->simplePaginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getReportToExport($params = false)
    {
        $filter = $params->filter;

        $approvals = $this->model->selectRaw('
      id as approval_id, approved_by, period_approved, user_id, DATE_FORMAT(date,"%Y/%m/%d") as date
      ')
          ->whereDate('date', '>=', date('Y-m-d', strtotime($filter->date->from)))
          ->whereDate('date', '<=', date('Y-m-d', strtotime($filter->date->to)))
          ->get();

        //   \DB::enableQueryLog(); // Enable query log
        $query = \DB::table('users as u')->selectRaw("
       u.id as checkin_by,
      CASE WHEN s.shifts THEN s.shifts ELSE 0 END as shifts,
      CASE WHEN `s`.`approval_id` THEN 'approved' ELSE '' END as approved,
      s.total_period_elapsed,
      CASE WHEN s.approval_id THEN s.total_period_elapsed ELSE 0 END as period_approved,
      s.date as date_for_approve,
      s.approval_id,
      s.approval_id as approved_by
      ")->leftJoin(\DB::raw('(
      SELECT COUNT(sSub.id) as shifts, SUM(sSub.period_elapsed) as total_period_elapsed, sSub.checkin_by, DATE_FORMAT(sSub.checkin_at,"%Y/%m/%d")as date, sSub.approval_id
        from icheckin__shifts as sSub
        where `sSub`.`checkin_at` >= "'.$filter->date->from.'"
        and `sSub`.`checkin_at` <= "'.$filter->date->to.'"
        group by sSub.checkin_by, DATE_FORMAT(sSub.checkin_at,"%Y/%m/%d"),sSub.approval_id) as s'),
            function ($join) {
                $join->on('u.id', 's.checkin_by');
            });

        if (isset($params->filter)) {
            //dd($query->toSql(),$query->getBindings());
            $filter = $params->filter;
            if (isset($filter->repId) && $filter->repId) {
                $query->where('u.id', $filter->repId);
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->where('u.id', 'like', '%'.$filter->search.'%')
                      ->orWhere('u.first_name', 'like', '%'.$filter->search.'%')
                      ->orWhere('u.last_name', 'like', '%'.$filter->search.'%')
                      ->orWhere('a.updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('a.created_at', 'like', '%'.$filter->search.'%');
                });
            }

            if (! isset($params->permissions['icheckin.shifts.index-all']) || ! $params->permissions['icheckin.shifts.index-all']) {
                $query->where('u.id', $params->user->id);
            } else {
                $query->whereIn('u.id', $filter->usersByDepartment);
            }
            /*
            if(!isset($params->permissions["icheckin.shifts.checkin"]) || !$params->permissions["icheckin.shifts.checkin"]){
              $query->whereNotIn("u.id",[$params->user->id]);
            }*/
        }

        $shifts = $query->get();

        foreach ($shifts as &$shift) {
            if (! $shift->approval_id) {
                $approval = $approvals->where('user_id', $shift->checkin_by)->where('date', $shift->date_for_approve)->first();
                if ($approval) {
                    $shift->date_for_approve = $approval->date;
                    $shift->period_approved = $approval->period_approved;
                    $shift->approved_by = $approval->approved_by;
                    $shift->approval_id = $approval->approval_id;
                }
            }
        }

        foreach ($shifts as &$shift) {
            $approval = $approvals->where('user_id', $shift->checkin_by)->where('date', $shift->date_for_approve)->first();

            if ($approval) {
                $shift->date_for_approve = $approval->date;
                $shift->period_approved = $approval->period_approved;
                $shift->approved_by = $approval->approved_by;
                if ($shift->approval_id != $approval->approval_id) {
                    $shift->approval_id = $approval->approval_id;
                }
            }

            $appvals = $approvals->filter(function ($aprvl, $key) use ($shift, $shifts) {
                return $aprvl->user_id == $shift->checkin_by && ! in_array($aprvl->date, $shifts->pluck('date_for_approve')->toArray());
            })->all();

            foreach ($appvals as $a) {
                $shifts->push((object) [
                    'checkin_by' => $a->user_id,
                    'shifts' => 0,
                    'approved' => 'approved',
                    'total_period_elapsed' => null,
                    'period_approved' => $a->period_approved,
                    'date_for_approve' => $a->date,
                    'approval_id' => $a->approval_id,
                    'approved_by' => $a->approved_by,
                ]);
            }
        }

        if (isset($filter->date) && (! isset($filter->repId) || ! $filter->repId)) {
            $date = $filter->date;
            $from = date('Y/m/d', strtotime($date->from));
            $to = date('Y/m/d', strtotime($date->to));
            if ($from != $to) {
                $shifts = $this->groupByUser($shifts);
            }
        }

        return json_decode(json_encode(ByShiftsReportTransformer::collection($shifts)), true);

        //$query->get();
        // \Log::info(\DB::getQueryLog()); // Show results of log
        //return $query->toSql();
        //dd($query->toSql(),$query->getBindings());
        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->simplePaginate($params->take);
        } else {
            $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function groupByUser($data)
    {
        $newData = [];

        foreach ($data as $item) {
            $findIt = false;
            $i = 0;

            while (count($newData) > $i && ! $findIt) {
                if ($item->checkin_by == $newData[$i]->checkin_by) {
                    $findIt = true;
                }

                $i++;
            }
            $i = $i - 1;
            if ($findIt) {
                $newData[$i]->shifts += $item->shifts;
                $newData[$i]->total_period_elapsed += $item->total_period_elapsed;
                $newData[$i]->period_approved += $item->period_approved;
            } else {
                array_push($newData, $item);
            }
        }

        return collect($newData);
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

    public function create($data)
    {
        $approval = Approvals::whereRaw('date = DATE_FORMAT("'.$data['date'].'","%Y/%m/%d")')
          ->where('user_id', $data['user_id'])
          ->first();

        if (! $approval) {
            $approval = $this->model->create($data);

            $shifts = Shift::whereRaw('DATE_FORMAT(checkin_at,"%Y/%m/%d") = DATE_FORMAT("'.$approval->date.'","%Y/%m/%d")')
              ->where('checkin_by', $data['user_id'])
              ->update(['approval_id' => $approval->id]);
        }

        return $approval;
    }

    public function updateBy($criteria, $data, $params = false)
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
        if ($model) {
            if (isset($data['approved_by'])) { // no reemplazar el primer approved by id
                unset($data['approved_by']);
            }

            $shifts = Shift::whereRaw('DATE_FORMAT(checkin_at,"%Y/%m/%d") = DATE_FORMAT("'.$model->date.'","%Y/%m/%d")')
              ->where('checkin_by', $model->user_id)
              ->update(['approval_id' => $model->id]);
        }

        return $model ? $model->update((array) $data) : false;
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
