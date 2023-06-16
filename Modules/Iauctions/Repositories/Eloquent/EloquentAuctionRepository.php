<?php

namespace Modules\Iauctions\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Iauctions\Repositories\AuctionRepository;
use Modules\Iprofile\Entities\Department;

class EloquentAuctionRepository extends EloquentCrudRepository implements AuctionRepository
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
        if (isset($filter->auctionId)) {
            $query->where('auction_id', $filter->auctionId);
        }

        // If doesn't have Permission to index-all
        if (\Auth::user() && ! \Auth::user()->hasAccess('iauctions.auctions.index-all')) {
            $userId = \Auth::user()->id;
            $departments = Department::whereHas('users', function ($q) use ($userId) {
                $q->where('iprofile__user_department.user_id', $userId);
            })->pluck('id')->toArray();

            $query->whereIn('department_id', $departments);
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
