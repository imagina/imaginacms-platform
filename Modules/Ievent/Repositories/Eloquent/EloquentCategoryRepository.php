<?php

namespace Modules\Ievent\Repositories\Eloquent;

use Illuminate\Support\Str;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ievent\Repositories\CategoryRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\UpdateMedia;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include)) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['files']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }

            //add filter by parent ID
            if (isset($filter->parentId)) {
                //find search in columns
                $query->where('parent_id', $filter->parentId);
            }

            //add filter by status
            if (isset($filter->status)) {
                //find search in columns

                $query->where('status', $filter->status);
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

        //dd($query->toSql());
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

    public function create($data)
    {
        $category = $this->model->create($data);

        if (isset($data['options']['mainImage'])) {
            $mainImage = $data['options']['mainImage'];

            if (Str::contains($mainImage, 'data:image/')) {
                $data['options']['mainImage'] = saveImage($mainImage, 'assets/ievent/category'.$category->id.'.jpg');
            } else {
                $data['options']['mainImage'] = 'modules/iblog/img/category/default.jpg';
            }
        }

        if (isset($data['options']['secondaryImage'])) {
            $secondaryImage = $data['options']['secondaryImage'];

            if (Str::contains($secondaryImage, 'data:image/')) {
                $data['options']['secondaryImage'] = saveImage($secondaryImage, 'assets/ievent/category'.$category->id.'.jpg');
            } else {
                $data['options']['secondaryImage'] = url('modules/iblog/img/category/default.jpg');
            }
        }

        $category->update($data);

        event(new CreateMedia($category, $data));

        return $category;
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
            if (isset($data['options']['mainImage'])) {
                $mainImage = $data['options']['mainImage'];

                if (Str::contains($mainImage, 'data:image/jpeg;base64')) {
                    $data['options']['mainImage'] = saveImage($mainImage, 'assets/ievent/category'.$model->id.'.jpg');
                } else {
                    $data['options']['mainImage'] = str_replace(url('').'/', '', $mainImage);
                }
            }

            if (isset($data['options']['secondaryImage'])) {
                $secondaryImage = $data['options']['secondaryImage'];

                if (Str::contains($secondaryImage, 'data:image/jpeg;base64')) {
                    $data['options']['secondaryImage'] = saveImage($secondaryImage, 'assets/ievent/category'.$model->id.'.jpg');
                } else {
                    $data['options']['secondaryImage'] = str_replace(url('').'/', '', $secondaryImage);
                }
            }

            $model->update((array) $data);

            event(new UpdateMedia($model, $data));
        }
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
