<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Events\PageIsCreating;
use Modules\Page\Events\PageIsUpdating;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;
use Modules\Page\Repositories\PageRepository;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class EloquentPageRepository extends EloquentBaseRepository implements PageRepository
{
    /**
     * {@inheritdoc}
     */
    public function paginate($perPage = 15)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with('translations')->paginate($perPage);
        }

        return $this->model->paginate($perPage);
    }

    /**
     * Find the page set as homepage
     */
    public function findHomepage()
    {
        return $this->model->where('is_home', 1)->first();
    }

    /**
     * Count all records
     */
    public function countAll()
    {
        return $this->model->count();
    }

    /**
     * @param  mixed  $data
     */
    public function create($data)
    {
        if (Arr::get($data, 'is_home') === '1') {
            $this->removeOtherHomepage();
        }

        event($event = new PageIsCreating($data));

        //Event creating model
        if (method_exists($this->model, 'creatingCrudModel')) {
            $this->model->creatingCrudModel(['data' => $data]);
        }

        //force it into the system name setter
        $data['system_name'] = $data['system_name'] ?? '';

        $page = $this->model->create($data);

        //Event created model
        if (method_exists($page, 'createdCrudModel')) {
            $page->createdCrudModel(['data' => $data]);
        }

        event(new PageWasCreated($page, $data));

        $page->setTags(Arr::get($data, 'tags', []));

        return $page;
    }

    /**
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {
        if (Arr::get($data, 'is_home') === '1') {
            $this->removeOtherHomepage($model->id);
        }

        event($event = new PageIsUpdating($model, $data));
        $model->update($event->getAttributes());

        event(new PageWasUpdated($model, $data));

        $model->setTags(Arr::get($data, 'tags', []));

        return $model;
    }

    public function destroy($page)
    {
        $page->untag();

        event(new PageWasDeleted($page));

        return $page->delete();
    }

    /**
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug, $locale) {
                $q->where('slug', $slug);
                $q->where('locale', $locale);
            })->with('translations')->first();
        }

        return $this->model->where('slug', $slug)->where('locale', $locale)->where('type', '!=', 'cms')->first();
    }

    /**
     * Set the current page set as homepage to 0
     *
     * @param  null  $pageId
     */
    private function removeOtherHomepage($pageId = null)
    {
        $homepage = $this->findHomepage();
        if ($homepage === null) {
            return;
        }
        if ($pageId === $homepage->id) {
            return;
        }

        $homepage->is_home = 0;
        $homepage->save();
    }

    /**
     * Paginating, ordering and searching through pages for server side index table
     */
    public function serverPaginationFilteringFor(Request $request): LengthAwarePaginator
    {
        $pages = $this->allWithBuilder();

        if ($request->get('search') !== null) {
            $term = $request->get('search');
            $pages->whereHas('translations', function ($query) use ($term) {
                $query->where('title', 'LIKE', "%{$term}%");
                $query->orWhere('slug', 'LIKE', "%{$term}%");
            })
              ->orWhere('id', $term);
        }

        if ($request->get('order_by') !== null && $request->get('order') !== 'null') {
            $order = $request->get('order') === 'ascending' ? 'asc' : 'desc';

            if (Str::contains($request->get('order_by'), '.')) {
                $fields = explode('.', $request->get('order_by'));

                $pages->with('translations')->join('page__page_translations as t', function ($join) {
                    $join->on('page__pages.id', '=', 't.page_id');
                })
                  ->where('t.locale', locale())
                  ->groupBy('page__pages.id')->orderBy("t.{$fields[1]}", $order);
            } else {
                $pages->orderBy($request->get('order_by'), $order);
            }
        }

        return $pages->paginate($request->get('per_page', 10));
    }

    /**
     * @return mixed
     */
    public function markAsOnlineInAllLocales(Page $page)
    {
        $data = [];
        foreach (app(LaravelLocalization::class)->getSupportedLocales() as $locale => $supportedLocale) {
            $data[$locale] = ['status' => 1];
        }

        return $this->update($page, $data);
    }

    /**
     * @return mixed
     */
    public function markAsOfflineInAllLocales(Page $page)
    {
        $data = [];
        foreach (app(LaravelLocalization::class)->getSupportedLocales() as $locale => $supportedLocale) {
            $data[$locale] = ['status' => 0];
        }

        return $this->update($page, $data);
    }

    /**
     * @param  array  $pageIds [int]
     * @return mixed
     */
    public function markMultipleAsOnlineInAllLocales(array $pageIds)
    {
        foreach ($pageIds as $pageId) {
            $this->markAsOnlineInAllLocales($this->find($pageId));
        }
    }

    /**
     * @param  array  $pageIds [int]
     * @return mixed
     */
    public function markMultipleAsOfflineInAllLocales(array $pageIds)
    {
        foreach ($pageIds as $pageId) {
            $this->markAsOfflineInAllLocales($this->find($pageId));
        }
    }

    public function getItemsBy($params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        /*== RELATIONSHIPS ==*/
        if (isset($params->include) && in_array('*', $params->include)) {//If Request all relationships
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

            if (isset($filter->tagId)) {
                $query->whereTag($filter->tagId, 'id');
            }

            //Order by
            if (isset($filter->order)) {
                $orderByField = $filter->order->field ?? 'created_at'; //Default field
                $orderWay = $filter->order->way ?? 'desc'; //Default way
                $query->orderBy($orderByField, $orderWay); //Add order to query
            }

            //add filter by search
            if (isset($filter->search) && $filter->search) {
                //find search in columns
                $term = $filter->search;
                $query->where(function ($query) use ($term, $filter) {
                    $query->whereHas('translations', function ($query) use ($term, $filter) {
                        $query->where('title', 'LIKE', "%{$term}%");
                        $query->orWhere('body', 'LIKE', "%{$term}%");
                        $query->orWhere('slug', 'LIKE', "%{$term}%");
                        $words = explode(' ', trim($filter->search));

                        //queryng word by word
                        if (count($words) > 1) {
                            foreach ($words as $index => $word) {
                                if (strlen($word) >= ($filter->minCharactersSearch ?? 3)) {
                                    $query->orWhere('title', 'like', '%'.$word.'%')
                                      ->orWhere('body', 'like', '%'.$word.'%');
                                }
                            }
                        }//foreach
                    })->orWhere(function ($query) use ($term) {
                        $query->whereTag($term, 'name');
                    })->orWhere('id', $term);
                });
            }

            //Order by
            if (isset($filter->type)) {
                $query->where('type', $filter->type); //Add order to query
            }

            // It is important because if the one who makes the change is the administrator, you must change the data of the organization and not those of the admin
            if (isset($filter->organizationId) && ! empty($filter->organizationId)) {
                $query->where('organization_id', $filter->organizationId);
            }

            if (isset($filter->id)) {
                ! is_array($filter->id) ? $filter->id = [$filter->id] : false;
                $query->where('id', $filter->id);
            }
        }

        $entitiesWithCentralData = json_decode(setting('isite::tenantWithCentralData', null, '[]', true));
        $tenantWithCentralData = in_array('page', $entitiesWithCentralData);

        if ($tenantWithCentralData && isset(tenant()->id)) {
            $model = $this->model;

            //If an organization is in the Iadmin, just show them their information
            //For the administrator does not apply because he has no organization
            // filter->type=="cms" - When they reload the iadmin they make a request looking for the cms types
            if ((isset($params->setting) && isset($params->setting->fromAdmin) && $params->setting->fromAdmin == false) || (isset($filter->type) && $filter->type == 'cms')) {
                $query->withoutTenancy();
            }

            $query->where(function ($query) use ($model) {
                $query->where($model->qualifyColumn(BelongsToTenant::$tenantIdColumn), tenant()->getTenantKey())
                  ->orWhereNull($model->qualifyColumn(BelongsToTenant::$tenantIdColumn));
            });
        }

        /*== FIELDS ==*/
        if (isset($params->fields) && count($params->fields)) {
            $query->select($params->fields);
        }

        //Validate index-all permission
        $userPermissions = $params->permissions ?? [];
        $hasIndexAll = $userPermissions['page.pages.index-all'] ?? false;
        if (! isset($params->allowIndexAll) && ! $hasIndexAll) {
            $query->whereNull('type');
        }

        /*== REQUEST ==*/
        if (isset($params->page) && $params->page) {
            return $query->paginate($params->take, ['*'], null, $params->page);
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

    public function updateBy($criteria, $data, $params = false)
    {
        /*== initialize query ==*/
        $query = $this->model->query();

        //Event updating model
        if (method_exists($this->model, 'updatingCrudModel')) {
            $this->model->updatingCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);
        }

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

        if (isset($model->id)) {
            if (Arr::get($data, 'is_home') === '1') {
                $this->removeOtherHomepage($model->id);
            }

            event($event = new PageIsUpdating($model, $data));

            //force it into the system name setter
            if (empty($data['system_name'])) {
                $data['system_name'] = $model->system_name;
            }

            $model->update($data);

            //Event updated model
            if (method_exists($model, 'updatedCrudModel')) {
                $model->updatedCrudModel(['data' => $data, 'params' => $params, 'criteria' => $criteria]);
            }

            event(new PageWasUpdated($model, $data));

            $model->setTags(Arr::get($data, 'tags', []));

            return $model;
        }

        return false;
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

        if (isset($model->id)) {
            $model->untag();

            event(new PageWasDeleted($model));

            return $model->delete();
        }

        return false;
    }
}
