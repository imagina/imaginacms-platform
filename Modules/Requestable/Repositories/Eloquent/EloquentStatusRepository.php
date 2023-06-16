<?php

namespace Modules\Requestable\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Requestable\Repositories\StatusRepository;

class EloquentStatusRepository extends EloquentCrudRepository implements StatusRepository
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

        // ORDER
        if (isset($params->order) && $params->order) {
            $order = is_array($params->order) ? $params->order : [$params->order];

            foreach ($order as $orderObject) {
                if (isset($orderObject->field) && isset($orderObject->way)) {
                    if (in_array($orderObject->field, $this->model->translatedAttributes)) {
                        $query->orderByTranslation($orderObject->field, $orderObject->way);
                    } else {
                        $query->orderBy($orderObject->field, $orderObject->way);
                    }
                }
            }
        } else {
      //Order by position by default
            $query->orderBy('position', 'asc'); //Add order to query
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
}
