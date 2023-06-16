<?php

namespace Modules\Iblog\Repositories\Eloquent;

use Illuminate\Support\Arr;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iblog\Entities\Category;
use Modules\Iblog\Entities\Status;
use Modules\Iblog\Repositories\PostRepository;

class EloquentPostRepository extends EloquentCrudRepository implements PostRepository
{
    /**
     * Filter names to replace
     *
     * @var array
     */
    protected $replaceFilters = [];

    /**
     * Relation names to replace
     *
     * @var array
     */
    protected $replaceSyncModelRelations = [];

    /**
     * Filter query
     *
     * @return mixed
     */
    public function filterQuery($query, $filter, $params)
    {
        if (isset($filter->id)) {
            ! is_array($filter->id) ? $filter->id = [$filter->id] : false;
            $query->whereIn('iblog__posts.id', $filter->id);
        }

        // add filter by Categories 1 or more than 1, in array
        if (isset($filter->categories) && ! empty($filter->categories)) {
            is_array($filter->categories) ? true : $filter->categories = [$filter->categories];
            $query->where(function ($query) use ($filter) {
                $query->whereRaw('iblog__posts.id IN (SELECT post_id from iblog__post__category where category_id IN ('.(implode(',', $filter->categories)).'))')
                  ->orWhereIn('iblog__posts.category_id', $filter->categories);
            });
        }

        //Filter by category
        if (isset($filter->category) && ! empty($filter->category)) {
            $categories = Category::descendantsAndSelf($filter->category);

            if ($categories->isNotEmpty()) {
                $query->where(function ($query) use ($categories) {
                    $query->where(function ($query) use ($categories) {
                        $query->whereRaw('iblog__posts.id IN (SELECT post_id from iblog__post__category where category_id IN ('.(implode(',', $categories->pluck('id')->toArray())).'))')
                          ->orWhereIn('iblog__posts.category_id', $categories->pluck('id'));
                    });
                });
            }
        }

        //Filter by category ID
        if (isset($filter->categoryId) && ! empty($filter->categoryId)) {
            ! is_array($filter->categoryId) ? $filter->categoryId = [$filter->categoryId] : false;

            $query->whereIn('iblog__posts.category_id', $filter->categoryId);
        }

        if (isset($filter->tagId)) {
            $query->whereTag($filter->tagId, 'id');
        }

        if (isset($filter->tagSlug)) {
            $query->whereTag($filter->tagSlug);
        }

        if (isset($filter->users) && ! empty($filter->users)) {
            $users = is_array($filter->users) ? $filter->users : [$filter->users];
            $query->whereIn('user_id', $users);
        }

        if (isset($filter->include) && ! empty($filter->include)) {
            $include = is_array($filter->include) ? $filter->include : [$filter->include];
            $query->whereIn('id', $include);
        }

        if (isset($filter->exclude) && ! empty($filter->exclude)) {
            $exclude = is_array($filter->exclude) ? $filter->exclude : [$filter->exclude];
            $query->whereNotIn('id', $exclude);
        }

        if (isset($filter->exclude_categories) && ! empty($filter->exclude_categories)) {
            $exclude_categories = is_array($filter->exclude_categories) ? $filter->exclude_categories : [$filter->exclude_categories];
            $query->whereRaw('iblog__posts.id NOT IN (SELECT post_id from iblog__post__category where category_id IN ('.(implode(',', $exclude_categories)).'))');
        }

        if (isset($filter->exclude_users) && ! empty($filter->exclude_users)) {
            $exclude_users = is_array($filter->exclude_users) ? $filter->exclude_users : [$filter->exclude_users];
            $query->whereNotIn('user_id', $exclude_users);
        }

        if (isset($filter->tag) && ! empty($filter->tag)) {
            $query->whereTag($filter->tag);
        }

        // add filter by search
        if (isset($filter->search) && ! empty($filter->search)) {
            $orderSearchResults = json_decode(setting('iblog::orderSearchResults'));

            // removing symbols used by MySQL
            $filter->search = preg_replace('/[^Ñña-zA-Z0-9]+/', ' ', $filter->search);
            $words = explode(' ', $filter->search); //Explode

            //Search query
            $query->leftJoin(\DB::raw(
                '(SELECT MATCH ('.implode(',', json_decode(setting('iblog::selectSearchFieldsPosts'))).") AGAINST ('(\"".$filter->search."\")' IN BOOLEAN MODE) scoreSearch1, post_id, title, ".
                ' MATCH ('.implode(',', json_decode(setting('iblog::selectSearchFieldsPosts'))).") AGAINST ('(+".$filter->search."*)' IN BOOLEAN MODE) scoreSearch2 ".
                'from iblog__post_translations '.
                "where `locale` = '".($filter->locale ?? locale())."') as ptrans"
            ), 'ptrans.post_id', 'iblog__posts.id')
              ->where(function ($query) {
                  $query->where('scoreSearch1', '>', 0)
                    ->orWhere('scoreSearch2', '>', 0);
              });

            foreach ($orderSearchResults ?? [] as $orderSearch) {
                $query->orderBy($orderSearch, 'desc');
            }

            unset($filter->order);
        }

        if (isset($filter->status) && ! empty($filter->status)) {
            ! is_array($filter->status) ? $filter->status = [$filter->status] : false;
            $query->whereRaw('id IN (SELECT post_id from iblog__post_translations where status = '.implode($filter->status)." and locale = '".($filter->locale ?? locale())."')");
        }

        // add filter by Categories Intersected 1 or more than 1, in array
        if (isset($filter->categoriesIntersected) && ! empty($filter->categoriesIntersected)) {
            is_array($filter->categoriesIntersected) ? true : $filter->categoriesIntersected = [$filter->categoriesIntersected];
            $query->where(function ($query) use ($filter) {
                foreach ($filter->categoriesIntersected as $categoryId) {
                    $query->whereRaw("iblog__posts.id IN (SELECT post_id from iblog__post__category where category_id = $categoryId)");
                }
            });
        }

        if (isset($filter->withoutInternal)) {
            $query->whereRaw('iblog__posts.category_id IN (SELECT id from iblog__categories where internal = 0)');
        }

        if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
        } else {
            //Pre filters by default
            $this->defaultPreFilters($query, $params);
        }

        //Response
        return $query;
    }

    /**
     * Method to sync Model Relations
     *
     * @param $model ,$data
     * @return $model
     */
    public function syncModelRelations($model, $data)
    {
        //Get model relations data from attribute of model
        $modelRelationsData = ($model->modelRelations ?? []);
        if (isset($data['categories']) && ! empty($data['categories'])) {
            $model->categories()->sync(array_merge($data['categories'] ?? [], [$model->category_id]));
        } else {
            $model->categories()->sync([$model->category_id]);
        }

        $model->setTags(Arr::get($data, 'tags', []));

        //Response
        return $model;
    }

    /**
     * Method to include relations to query
     */
    public function includeToQuery($query, $relations)
    {
        //request all categories instances in the "relations" attribute in the entity model
        if (in_array('*', $relations)) {
            $relations = $this->model->getRelations() ?? ['translations', 'files', 'category'];
        }
        //Instance relations in query
        $query->with($relations);
        //Response
        return $query;
    }

    public function defaultPreFilters($query, $params)
    {
        //pre-filter date_available
        $query->where(function ($query) {
            $query->where('date_available', '<=', date('Y-m-d', strtotime(now())));
            $query->orWhereNull('date_available');
        });

        $query->whereRaw('iblog__posts.category_id IN (SELECT category_id from iblog__category_translations where status = 1)');

        //pre-filter status
        $query->whereRaw("id IN (SELECT post_id from iblog__post_translations where status = 2 and locale = '".($params->filter->locale ?? locale())."')");
    }
}
