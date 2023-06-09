<?php

namespace Modules\Idocs\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Events\DocumentWasDeleted;
use Modules\Idocs\Events\DocumentWasUpdated;
use Modules\Idocs\Repositories\DocumentRepository;

class EloquentDocumentRepository extends EloquentBaseRepository implements DocumentRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
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

            if (isset($filter->identification)) {
                $query->where('user_identification', $filter->identification);
            }
            if (isset($filter->categoryId)) {
                $query->where('category_id', $filter->categoryId);
            }
            if (isset($filter->key)) {
                $query->where('key', $filter->key);
            }
            if (isset($filter->private)) {
                $query->where('private', $filter->private);
            }
            if (isset($filter->status)) {
                $query->whereStatus($filter->status);
            }

            //add filter by search
            if (isset($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($query) use ($filter) {
                        $query->where('locale', $filter->locale)
                          ->where('title', 'like', '%'.$filter->search.'%');
                    })->orWhere('idocs__documents.id', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });
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

            if (isset($filter->id)) {
                ! is_array($filter->id) ? $filter->id = [$filter->id] : false;
                $query->where('id', $filter->id);
            }
        }

        $user = $params->user ?? \Auth::user();
        $route = request()->route()->getName();
        $locale = \App::getLocale();
        if (isset($user->id) && (! isset($filter->private) || ! $filter->private)
          && $route != $locale.'.idocs.index.public') {
            if (! isset($params->permissions['media.medias.index-all']) ||
              (isset($params->permissions['media.medias.index-all']) &&
                ! $params->permissions['media.medias.index-all'])) {
                $query->with('users')->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
                $query->where('status', 1);
            }
        } else {
            $query->where('private', false);
            $query->where('status', 1);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take);
        } else {
            isset($params->take) && $params->take ? $query->take($params->take) : false; //Take

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

            if (isset($filter->key) and ! empty($filter->key)) {
                $query->where('key', $filter->key);
            }
        }

        $user = $params->user ?? \Auth::user();

        if (isset($user->id)) {
            if (! isset($params->permissions['media.medias.index-all']) ||
              (isset($params->permissions['media.medias.index-all']) &&
                ! $params->permissions['media.medias.index-all'])) {
                $query->with('users')->whereHas('users', function ($q) use ($user) {
                    $q->where('users.id', $user->id);
                });
                $query->where('status', 1);
            }
        } else {
            if (! isset($filter->key)) {
                $query->where('private', false);
            }

            $query->where('status', 1);
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        //dd($query->toSql(),$query->getBindings(),$query->first());
        /*== REQUEST ==*/
        return $query->where($field ?? 'id', $criteria)->first();
    }

    /**
     * @param $param
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search($keys): Collection
    {
        $query = $this->model->query();
        $criterion = $keys;
        $query->whereHas('translations', function (Builder $q) use ($criterion) {
            $q->where('title', 'like', "%{$criterion}%");
        });
        $query->orWhere('id', $criterion);

        return $query->orderBy('created_at', 'desc')->paginate(20);
    }

    /**
     * Standard Api Method
     * Create a iblog post
     *
     * @param  array  $data
     * @return Post
     */
    public function create(array $data): Post
    {
        $document = $this->model->create($data);

        event(new DocumentWasCreated($document, $data));

        return $document;
    }

    /**
     * Update a resource
     *
     * @param $documnet
     * @param  array  $data
     * @return mixed
     */
    public function update($document, array $data)
    {
        $document->update($data);

        event(new DocumentWasUpdated($document, $data));

        return $document;
    }

    public function destroy($model)
    {
        event(new DocumentWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }

    public function whereCategory($id)
    {
        $query = $this->model->with('categories', 'category', 'user', 'translations');
        $query->whereHas('categories', function ($q) use ($id) {
            $q->where('category_id', $id);
        })->whereStatus(1)->where('created_at', '<', date('Y-m-d H:i:s'))->orderBy('created_at', 'DESC');

        return $query->paginate(setting('idocs::docs-per-page'));
    }
}
