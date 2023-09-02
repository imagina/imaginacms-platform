<?php

namespace Modules\Isite\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Isite\Repositories\CategoryRepository;

class EloquentCategoryRepository extends EloquentCrudRepository implements CategoryRepository
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
        /**
         * Note: Add filter name to replaceFilters attribute before replace it
         *
         * Example filter Query
         * if (isset($filter->status)) $query->where('status', $filter->status);
         */
        if (isset($filter->search)) { //si hay que filtrar por rango de precio
            $query->where(function ($query) use ($filter) {
                $query->whereHas('translations', function (Builder $q) use ($filter) {
                    $q->where('title', 'like', "%{$filter->search}%");
                });
            })->orWhere('id', 'like', '%'.$filter->search.'%');
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

        /**
         * Note: Add relation name to replaceSyncModelRelations attribute before replace it
         *
         * Example to sync relations
         * if (array_key_exists(<relationName>, $data)){
         *    $model->setRelation(<relationName>, $model-><relationName>()->sync($data[<relationName>]));
         * }
         */

        //Response
        return $model;
    }

    /**
     * Find a resource by the given slug
     */
    public function findBySlug($slug)
    {
        if (method_exists($this->model, 'translations')) {
            $query = $this->model->whereHas('translations', function (Builder $q) use ($slug) {
                $q->where('slug', $slug);
            })->with('translations', 'parent', 'children');
        } else {
            $query = $this->model->where('slug', $slug)->with('translations', 'parent', 'children');
        }

        $entitiesWithCentralData = json_decode(setting('isite::tenantWithCentralData', null, '[]'));
        $tenantWithCentralData = in_array('categories', $entitiesWithCentralData);

        if ($tenantWithCentralData && isset(tenant()->id)) {
            $model = $this->model;

            $query->withoutTenancy();
            $query->where(function ($query) use ($model) {
                $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
                  ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
            });
        }

        return $query->first();
    }
}
