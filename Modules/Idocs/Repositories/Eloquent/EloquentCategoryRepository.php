<?php

namespace Modules\Idocs\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Idocs\Events\CategoryWasCreated;
use Modules\Idocs\Events\CategoryWasDeleted;
use Modules\Idocs\Events\CategoryWasUpdated;
use Modules\Idocs\Repositories\CategoryRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
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

            if (isset($filter->private)) {
                $query->where('private', $filter->private);
            }

            if (isset($filter->parentId)) {
                $query->where('parent_id', $filter->parentId);
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

        $authUser = \Auth::user();
        if (! isset($authUser->id)) {
            $query->where('private', false);
        } else {
            if (! isset($params->permissions['media.medias.index-all']) ||
              (isset($params->permissions['media.medias.index-all']) &&
                ! $params->permissions['media.medias.index-all'])) {
                $query->where('private', false);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        //dd($params,$query->toSql(),$query->getBindings());
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
        if (in_array('*', $params->include ?? [])) { //If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = []; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include ?? []);
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

            if (isset($filter->private)) {
                $query->where('private', $filter->private);
            }
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        if (! isset($params->filter->field)) {
            $query->where('id', $criteria);
        }

        /*== REQUEST ==*/
        return $query->first();
    }

    /**
     * Find a resource by the given slug
     *
     * @param  string  $slug
     * @return object
     */
    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with('translations', 'parent', 'children', 'documents')->firstOrFail();
        }

        return $this->model->where('slug', $slug)->with('translations', 'parent', 'children', 'documents')->first();
    }

    /**
     * Standard Api Method
     *
     * @return mixed
     */
    public function create($data)
    {
        $category = $this->model->create($data);

        event(new CategoryWasCreated($category, $data));

        return $this->find($category->id);
    }

    /**
     * Update a resource
     *
     * @param  array  $data
     * @return mixed
     */
    public function update($category, $data)
    {
        $category->update($data);

        event(new CategoryWasUpdated($category, $data));

        return $category;
    }

    public function destroy($model)
    {
        event(new CategoryWasDeleted($model->id, get_class($model)));

        return $model->delete();
    }
}
