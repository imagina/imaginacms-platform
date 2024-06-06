<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Events\PageIsCreating;
use Modules\Page\Events\PageIsUpdating;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;
use Modules\Page\Repositories\PageRepository;

class EloquentPageRepository extends EloquentBaseRepository implements PageRepository
{
  /**
   * @inheritdoc
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
   * @return object
   */
  public function findHomepage()
  {
    return $this->model->where('is_home', 1)->first();
  }
  
  /**
   * Count all records
   * @return int
   */
  public function countAll()
  {
    return $this->model->count();
  }
  
  /**
   * @param  mixed $data
   * @return object
   */
  public function create($data)
  {
    if (array_get($data, 'is_home') === '1') {
      $this->removeOtherHomepage();
    }
    
    event($event = new PageIsCreating($data));
    $page = $this->model->create($event->getAttributes());
    
    event(new PageWasCreated($page, $data));
    
    $page->setTags(array_get($data, 'tags', []));
    
    return $page;
  }
  
  /**
   * @param $model
   * @param  array $data
   * @return object
   */
  public function update($model, $data)
  {
    if (array_get($data, 'is_home') === '1') {
      $this->removeOtherHomepage($model->id);
    }
    
    event($event = new PageIsUpdating($model, $data));
    $model->update($event->getAttributes());
    
    event(new PageWasUpdated($model, $data));
    
    $model->setTags(array_get($data, 'tags', []));
    
    return $model;
  }
  
  public function destroy($page)
  {
    $page->untag();
    
    event(new PageWasDeleted($page));
    
    return $page->delete();
  }
  
  /**
   * @param $slug
   * @param $locale
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
    
    return $this->model->where('slug', $slug)->where('locale', $locale)->first();
  }
  
  /**
   * Set the current page set as homepage to 0
   * @param null $pageId
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
   * @param Request $request
   * @return LengthAwarePaginator
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
      
      if (str_contains($request->get('order_by'), '.')) {
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
   * @param Page $page
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
   * @param Page $page
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
   * @param array $pageIds [int]
   * @return mixed
   */
  public function markMultipleAsOnlineInAllLocales(array $pageIds)
  {
    foreach ($pageIds as $pageId) {
      $this->markAsOnlineInAllLocales($this->find($pageId));
    }
  }
  
  /**
   * @param array $pageIds [int]
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
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter
      
      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }
      
      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }
      
      //add filter by search
      if (isset($filter->search) && $filter->search) {
        //find search in columns
          $term = $filter->search;
        $query->where(function ($subQuery) use ($term) {
          $subQuery->whereHas('translations', function ($q) use ($term) {
            $q->where('title', 'LIKE', "%{$term}%");
            $q->orWhere('slug', 'LIKE', "%{$term}%");
          })
            ->orWhere('id', $term);
        });
        
      }
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
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
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;
    }
    
    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);
    
    /*== REQUEST ==*/
    return $query->where($field ?? 'id', $criteria)->first();
  }
  
  
  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();
    
    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;
      
      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }
    
    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    
    if(isset($model->id)){
  
      if (array_get($data, 'is_home') === '1') {
        $this->removeOtherHomepage($model->id);
      }
  
      event($event = new PageIsUpdating($model, $data));
      $model->update($event->getAttributes());
  
      event(new PageWasUpdated($model, $data));
  
      $model->setTags(array_get($data, 'tags', []));
  
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
      
      if (isset($filter->field))//Where field
        $field = $filter->field;
    }
    
    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    
    if(isset($model->id)){
      $model->untag();
  
      event(new PageWasDeleted($model));
  
      return $model->delete();
      
    }
    return false;
  }
}
