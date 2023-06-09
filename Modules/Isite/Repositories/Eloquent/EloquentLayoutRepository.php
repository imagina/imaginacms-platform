<?php

namespace Modules\Isite\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Isite\Repositories\LayoutRepository;

class EloquentLayoutRepository extends EloquentCrudRepository implements LayoutRepository
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
        /*
            * Se aplica para que el layout se pueda encontrar a pesar
            de ser "internal"
            */

        $query->where('is_internal', 0);

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
}
