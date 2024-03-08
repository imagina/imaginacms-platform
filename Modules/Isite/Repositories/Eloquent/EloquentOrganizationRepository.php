<?php

namespace Modules\Isite\Repositories\Eloquent;

use Modules\Core\Icrud\Repositories\Eloquent\EloquentCrudRepository;
use Modules\Isite\Repositories\OrganizationRepository;

class EloquentOrganizationRepository extends EloquentCrudRepository implements OrganizationRepository
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
      //
      if (\Auth::id() && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
        if (!isset($params->permissions['isite.organizations.index-all']) || !$params->permissions['isite.organizations.index-all']) {
          $query->whereHas('users', function ($query) {
            $query->where('users.id', \Auth::id());
          });
        }
      }
  
      /**
       * Note: Add filter name to replaceFilters attribute before replace it
       *
       * Example filter Query
       * if (isset($filter->status)) $query->where('status', $filter->status);
       */
  
      //Filter Category Id
      if (isset($filter->category) && !empty($filter->category)) {
        $query->where('category_id', $filter->category);
      }

      // add filter by search
      if (isset($filter->search) && !empty($filter->search)) {

        //get language translation
        $lang = \App::getLocale();

        $query->where(function ($query) use ($filter, $lang) {
          $query->whereHas('translations', function ($query) use ($filter, $lang) {
            $query->where('locale', $lang)
              ->where('title', 'like', '%' . $filter->search . '%')
              ->orWhere('description', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%');
        });

      }

      if (isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin) {
      } else {
        //Pre filters by default
        $query->where('status', 1);
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
