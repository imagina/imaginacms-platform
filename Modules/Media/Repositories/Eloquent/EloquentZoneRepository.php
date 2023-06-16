<?php

namespace Modules\Media\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Media\Repositories\ZoneRepository;

class EloquentZoneRepository extends EloquentCrudRepository implements ZoneRepository
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
