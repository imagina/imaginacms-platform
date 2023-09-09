<?php

namespace Modules\Iplaces\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Ihelpers\Events\CreateMedia;
use Modules\Ihelpers\Events\DeleteMedia;
use Modules\Ihelpers\Events\UpdateMedia;
use Modules\Iplaces\Entities\Category;
use Modules\Iplaces\Entities\Status;
use Modules\Iplaces\Events\PlaceWasCreated;
use Modules\Iplaces\Repositories\PlaceRepository;

class EloquentPlaceRepository extends EloquentBaseRepository implements PlaceRepository
{
    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations', 'categories', 'files']; //Default relationships
            if (isset($params->include)) {//merge relations with default relationships
                $includeDefault = array_merge($includeDefault, $params->include);
            }
            $query->with($includeDefault); //Add Relationships to query
        }

        /*== FILTERS ==*/
        if (isset($params->filter)) {
            $filter = $params->filter; //Short filter

            if (isset($filter->Id)) {
                ! is_array($filter->Id) ? $filter->Id = [$filter->Id] : false;
                $query->whereIn('id', $filter->Id);
            }

            // add filter by Categories 1 or more than 1, in array
            if (isset($filter->categories) && ! empty($filter->categories)) {
                is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
                $query->where(function ($query) use ($filter) {
                    $query->whereRaw('iplaces__places.id IN (SELECT place_id from iplaces__place_category where category_id IN ('.(implode(',', $filter->categories->pluck('id')->toArray())).'))')
                      ->orWhereIn('iplaces__places.category_id', $filter->categories->pluck('id'));
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

            // add filter by Categories Intersected 1 or more than 1, in array
            if (isset($filter->categoriesIntersected) && ! empty($filter->categoriesIntersected)) {
                is_array($filter->categoriesIntersected) ? true : $filter->categoriesIntersected = [$filter->categoriesIntersected];
                $query->where(function ($query) use ($filter) {
                    foreach ($filter->categoriesIntersected as $categoryId) {
                        $query->whereRaw("iplaces__places.id IN (SELECT place_id from iplaces__place_category where category_id = $categoryId)");
                    }
                });
            }

            //New filter by search
            if (isset($filter->search) && ! empty($filter->search)) {
                //find search in columns
                $query->where(function ($query) use ($filter) {
                    $query->whereHas('translations', function ($query) use ($filter) {
                        $query->where('locale', $filter->locale ?? locale())
                          ->where(function ($query) use ($filter) {
                              $query->where('title', 'like', '%'.$filter->search.'%')
                                ->orWhere('description', 'like', '%'.$filter->search.'%');

                              $words = explode(' ', trim($filter->search));

                              if (count($words) > 1) {
                                  foreach ($words as $index => $word) {
                                      if (strlen($word) >= ($filter->minCharactersSearch ?? 3)) {
                                          $query->orWhere('title', 'like', '%'.$word.'%')
                                            ->orWhere('description', 'like', '%'.$word.'%');
                                      }
                                  }
                              }//foreach
                          });
                    })->orWhere(function ($query) use ($filter) {
                        $query->whereTag($filter->search, 'name');
                    })
                      ->orWhere('iplaces__places.id', 'like', '%'.$filter->search.'%')
                      ->orWhere('updated_at', 'like', '%'.$filter->search.'%')
                      ->orWhere('created_at', 'like', '%'.$filter->search.'%');
                });

                /*

                // removing symbols used by MySQL
                $filter->search = preg_replace("/[^a-zA-Z0-9]+/", " ", $filter->search);
                $words = explode(" ", $filter->search);//Explode

                //Validate words of minum 3 length
                foreach ($words as $key => $word) {
                  if (strlen($word) >= 3) {
                    $words[$key] = '+' . $word . '*';
                  }
                }

                //Search query
                $query->leftJoin(\DB::raw(
                  "(SELECT MATCH (title) AGAINST ('(" . implode(" ", $words) . ") (" . $filter->search . ")' IN BOOLEAN MODE) scoreSearch,

                  place_id, title " .
                  "from iplaces__place_translations " .
                  "where `locale` = '".($filter->locale ?? locale())."') as ptrans"
                ), 'ptrans.place_id', 'iplaces__places.id')
                  ->where('scoreSearch', '>', 0)
                  ->orderBy('scoreSearch', 'desc');

                //Remove order by
                unset($filter->order);
                */
                // dd($params,$filter->search,$query ,$words);
            }

            //Filter by category ID
            if (isset($filter->category) && ! empty($filter->category)) {
                $categories = Category::descendantsAndSelf($filter->category);

                if ($categories->isNotEmpty()) {
                    $query->where(function ($query) use ($categories) {
                        $query->where(function ($query) use ($categories) {
                            $query->whereRaw('iplaces__places.id IN (SELECT place_id from iplaces__place_category where category_id IN ('.(implode(',', $categories->pluck('id')->toArray())).'))')
                              ->orWhereIn('iplaces__places.category_id', $categories->pluck('id'));
                        });
                    });
                }
            }

            if (isset($filter->tagId)) {
                $query->whereTag($filter->tagId, 'id');
            }

            if (isset($filter->status) && ! empty($filter->status)) {
                $query->whereStatus($filter->status);
            }

            if (isset($filter->id)) {
                ! is_array($filter->id) ? $filter->id = [$filter->id] : false;
                $query->where('id', $filter->id);
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
            isset($params->take) && $params->take ? $query->take($params->take) : false; //Take

            return $query->get();
        }
    }

    public function getItem($criteria, $params = false)
    {
        //Initialize query
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (in_array('*', $params->include ?? [])) {//If Request all relationships
            $query->with([]);
        } else {//Especific relationships
            $includeDefault = ['translations', 'categories', 'files']; //Default relationships
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
    //Event creating model
    if (method_exists($this->model, 'creatingCrudModel'))
      $this->model->creatingCrudModel(['data' => $data]);

        $place = $this->model->create($data);
        event(new PlaceWasCreated($place, $data));
        $place->categories()->sync(Arr::get($data, 'categories', []));
        $place->services()->sync(Arr::get($data, 'services', []));
        $place->spaces()->sync(Arr::get($data, 'spaces', []));

    //Event created model
    if (method_exists($place, 'createdCrudModel'))
      $place->createdCrudModel(['data' => $data]);

        event(new CreateMedia($place, $data));
        $place->setTags(Arr::get($data, 'tags', []));

    return $place;
    }

    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

    //Event updating model
    if (method_exists($this->model, 'updatingCrudModel'))
      $this->model->updatingCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

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
            $model->update((array) $data);
            $model->categories()->sync(Arr::get($data, 'categories', []));

      if (method_exists($model, 'updatedCrudModel'))
        $model->updatedCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);

            event(new UpdateMedia($model, $data));
            $model->setTags(Arr::get($data, 'tags', []));
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
        event(new DeleteMedia($model->id, get_class($model)));
    }

    public function update($model, $data)
    {
        $model->update($data);
        $model->categories()->sync(Arr::get($data, 'categories', []));
        $model->services()->sync(Arr::get($data, 'services', []));
        $model->spaces()->sync(Arr::get($data, 'spaces', []));
        $model->setTags(Arr::get($data, 'tags', []));

        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function findBySlug($slug)
    {
        $query = $this->model->query();
        if (method_exists($this->model, 'translations')) {
            $query->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with('categories', 'city', 'category', 'translations', 'province');
        } else {
            $query->where('slug', $slug)->with('categories', 'city', 'category', 'province');
        }
        $query->whereStatus(Status::ACTIVE);

        return $query->firstOrFail();
    }

    public function whereCategory($id)
    {
        is_array($id) ? true : $id = [$id];
        $query = $this->model->with('city', 'category', 'province');
        $query->whereHas('categories', function (Builder $q) use ($id) {
            $q->whereIn('category_id', $id);
        });
        $query->orderBy('created_at', 'desc');
        $query->whereStatus(Status::ACTIVE);

        return $query->paginate(12);
    }
}
