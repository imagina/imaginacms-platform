<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Menu\Repositories\MenuRepository;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Repositories\PageRepository;

class CMSSidebarDatabaseSeeder extends Seeder
{
  /**
   * @var PageRepository
   */
  private $menu;
  private $menuitems;
  private $pages;

  public function __construct(MenuRepository $menu, MenuItemRepository $menuitems, PageRepository $pages)
  {
    $this->menu = $menu;
    $this->menuitems = $menuitems;
    $this->pages = $pages;
  }

  public function run()
  {
    Model::unguard();

    $modules = app('modules');
    $enabledModules = $modules->allEnabled();//Get all modules
    $cmsSidebars = [];

    //Get cmsPages from enable modules
    foreach (array_keys($enabledModules) as $moduleName) {
      $cmsSidebars[$moduleName] = config("asgard." . strtolower($moduleName) . ".cmsSidebar") ?? [];
    }

    //Delete menus
    $this->menu->whereIn("name", ['cms_admin', 'cms_panel'])
      ->whereDate('created_at', '<=', '2022-03-18')->delete();

    //Get the cms menus
    $menuAdmin = $this->getOrCreateMenu('cms_admin', 'adminMenu');
    $panelMenu = $this->getOrCreateMenu('cms_panel', 'panelMenu');

    //Insert cms pages
    foreach ($cmsSidebars as $moduleName => $menuTypes) {
      foreach ($menuTypes as $type => $menus) {
        foreach ($menus as $name => $menu) {
          //Instance the menu id
          $menuId = ($type == 'admin') ? $menuAdmin->id : $panelMenu->id;
          //Instance system name
          $systemName = strtolower("{$moduleName}_cms_{$type}_{$name}");

          if (is_array($menu)) {
            //Translate page title
            $title = explode('.', $menu['title']);
            $prefix = array_shift($title);
            $title = "{$prefix}::" . join('.', $title);
            //Insert parent item
            $menuItem = $this->insertItemPage([
              'menu_id' => $menuId,
              "icon" => $menu['icon'],
              "system_name" => $systemName,
              'en' => ['title' => trans($title, [], "en")],
              'es' => ['title' => trans($title, [], "es")],
            ]);
            //Insert item by page
            if (isset($menu['children']) && is_array($menu['children'])) {
              foreach ($menu['children'] as $index => $child) {
                $this->insertItemPage([
                  "menu_id" => $menuId,
                  "system_name" => "{$systemName}_{$index}",
                  "parent_id" => $menuItem->id
                ], $child);
              }
            }
          } else {
            $this->insertItemPage([
              "menu_id" => $menuId,
              "system_name" => $systemName
            ], $menu);
          }
        }
      }
    }
  }

  /**
   * Get or create menu by name and title
   * @param $name
   * @param $title
   * @return mixed
   */
  public function getOrCreateMenu($name, $title)
  {
    //Get menu
    $menu = $this->menu->where('name', $name)->first();
    //Create menu if not exist
    if (!$menu) {
      //Create Menu
      $menu = $this->menu->create([
        'name' => $name,
        'en' => ['title' => $title, "status" => 1],
        'es' => ['title' => $title, "status" => 1],
      ]);
      //Remove all items (root)
      $this->menuitems->where('menu_id', $menu->id)->delete();
    }
    //Return menu
    return $menu;
  }

  /**
   * Insert an item by menuId
   * @param $itemData
   * @param $pageName
   * @return mixed
   */
  public function insertItemPage($itemData, $pageName = false)
  {
    //Get menu item
    $menuItem = $this->menuitems->where('system_name', $itemData['system_name'])->first();
    //Get page
    $page = $pageName ? $this->pages->where('system_name', $pageName)->first() : null;

    if (!$menuItem) {
      //Set positions
      $positions = ['isite_cms_main_home' => 0, 'isite_cms_admin_index' => 2];

      //Set extra itemData
      if ($page) $itemData = $this->mergeItemPageData($itemData, $page);

      //Set extra data
      $itemData["position"] = isset($positions[$pageName]) ? $positions[$pageName] : 1;
      $itemData["en"]["status"] = 1;
      $itemData["es"]["status"] = 1;

      //Create menu item
      $menuItem = $this->menuitems->create($itemData);
    } else {
      //Validate page_id if menuItem already exist
      if ($menuItem->page_id && !$this->pages->find($menuItem->page_id)) {
        $itemData = array_merge($itemData, ['page_id' => $page ? $page->id : null]);
      } else if (!$menuItem->page_id && $page) {
        $itemData = $this->mergeItemPageData($itemData, $page);
      }
      //Update itemData
      $menuItem->update($itemData);
    }

    //Return item
    return $menuItem;
  }

  //Merge page data with itemData
  public function mergeItemPageData($itemData, $pageData)
  {
    return array_merge($itemData, [
      "icon" => $pageData->options->icon ?? 'fas fa-circle',
      "page_id" => $pageData->id,
      'en' => ['title' => $pageData->translate("en")['title'] ?? $pageData->title],
      'es' => ['title' => $pageData->translate("es")['title'] ?? $pageData->title],
    ]);
  }
}
