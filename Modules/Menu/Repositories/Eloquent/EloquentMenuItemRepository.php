<?php

namespace Modules\Menu\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Menu\Events\MenuItemIsCreating;
use Modules\Menu\Events\MenuItemIsUpdating;
use Modules\Menu\Events\MenuItemWasCreated;
use Modules\Menu\Events\MenuItemWasUpdated;
use Modules\Menu\Repositories\MenuItemRepository;

class EloquentMenuItemRepository extends EloquentBaseRepository implements MenuItemRepository
{
  public function create($data)
  {
    event($event = new MenuItemIsCreating($data));
    $menuItem = $this->model->create($event->getAttributes());

    event(new MenuItemWasCreated($menuItem));

    return $menuItem;
  }

  public function update($menuItem, $data)
  {
    event($event = new MenuItemIsUpdating($menuItem, $data));
    $menuItem->update($event->getAttributes());

    event(new MenuItemWasUpdated($menuItem));

    return $menuItem;
  }

  /**
   * Get online root elements
   *
   * @param int $menuId
   * @return object
   */
  public function rootsForMenu($menuId)
  {
    return $this->model->whereHas('translations', function (Builder $q) {
      $q->where('status', 1);
      $q->where('locale', App::getLocale());
    })->with('translations')->whereMenuId($menuId)->orderBy('position')->get();
  }

  /**
   * Get all root elements
   *
   * @param int $menuId
   * @return object
   */
  public function allRootsForMenu($menuId)
  {
    return $this->model->with('translations')->whereMenuId($menuId)->orderBy('parent_id')->orderBy('position')->get();
  }

  /**
   * Get Items to build routes
   *
   * @return Array
   */
  public function getForRoutes()
  {
    $menuitems = DB::table('menu__menus')
      ->select(
        'primary',
        'menu__menuitems.id',
        'menu__menuitems.parent_id',
        'menu__menuitems.module_name',
        'menu__menuitem_translations.uri',
        'menu__menuitem_translations.locale'
      )
      ->join('menu__menuitems', 'menu__menus.id', '=', 'menu__menuitems.menu_id')
      ->join('menu__menuitem_translations', 'menu__menuitems.id', '=', 'menu__menuitem_translations.menuitem_id')
      ->where('uri', '!=', '')
      ->where('module_name', '!=', '')
      ->where('status', '=', 1)
      ->where('primary', '=', 1)
      ->orderBy('module_name')
      ->get();

    $menuitemsArray = [];
    foreach ($menuitems as $menuitem) {
      $menuitemsArray[$menuitem->module_name][$menuitem->locale] = $menuitem->uri;
    }

    return $menuitemsArray;
  }

  /**
   * Get the root menu item for the given menu id
   *
   * @param int $menuId
   * @return object
   */
  public function getRootForMenu($menuId)
  {
    return $this->model->with('translations')->where(['menu_id' => $menuId, 'is_root' => true])->firstOrFail();
  }

  /**
   * Return a complete tree for the given menu id
   *
   * @param int $menuId
   * @return object
   */
  public function getTreeForMenu($menuId)
  {
    $items = $this->rootsForMenu($menuId);

    return $items->noCleaning()->nest();
  }

  /**
   * @param string $uri
   * @param string $locale
   * @return object
   */
  public function findByUriInLanguage($uri, $locale)
  {
    return $this->model->whereHas('translations', function (Builder $q) use ($locale, $uri) {
      $q->where('status', 1);
      $q->where('locale', $locale);
      $q->where('uri', $uri);
    })->with('translations')->first();
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
        $orderByField = $filter->order->field ?? 'position';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }

      // Filter By Menu
      if (isset($filter->menu)) {
        $query->where('menu_id', $filter->menu);
      }

      //add filter by search
      if (isset($filter->search)) {
        //find search in columns
        $query->where(function ($query) use ($filter) {
          $query->whereHas('translations', function ($query) use ($filter) {
            $query->where('locale', $filter->locale)
              ->where('title', 'like', '%' . $filter->search . '%');
          })->orWhere('id', 'like', '%' . $filter->search . '%')
            ->orWhere('updated_at', 'like', '%' . $filter->search . '%')
            ->orWhere('created_at', 'like', '%' . $filter->search . '%');
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
        $query->where($filter->field, $criteria);
      else//Filter by ID
        $query->where('id', $criteria);
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->first();
  }


  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    //FILTER
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    //Get model
    $model = $query->where($field ?? 'id', $criteria)->first();
    if (!$model) return false;//Validate model

    //Update menu item
    event($event = new MenuItemIsUpdating($model, $data));
    $model->update($event->getAttributes());
    event(new MenuItemWasUpdated($model));
    return $model;
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
    $model ? $model->delete() : false;
  }

  public function updateItems($criterias, $data)
  {
    $query = $this->model->query();
    $query->whereIn('id', $criterias)->update($data);
    return $query;


  }

  public function deleteItems($criterias)
  {
    $query = $this->model->query();

    $query->whereIn('id', $criterias)->delete();

    return $query;

  }

  public function updateOrders($data)
  {
    $menuitems = [];
    foreach ($data['menuitems'] as $menuitem) {
      $menuitems[] = $this->model->find($menuitem['id'])
        ->update([
          'position' => $menuitem['position'],
          'parent_id' => $menuitem['parent_id']
        ]);
    }
    return $menuitems;
  }

}
