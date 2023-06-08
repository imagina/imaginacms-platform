<?php

namespace Modules\Menu\Events\Handlers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Menu\Entities\Menuitem;
use Modules\Menu\Events\MenuItemWasCreated;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Menu\Repositories\MenuRepository;
use Nwidart\Menus\Facades\Menu as MenuFacade;
use Nwidart\Menus\MenuBuilder as Builder;
use Nwidart\Menus\MenuItem as PingpongMenuItem;

class RegisterMenusInCache
{
  /**
   * @var MenuItemRepository
   */
  private $menuItem;
  
  public function __construct(MenuItemRepository $menuItem)
  {
    $this->menuItem = $menuItem;
  }
  
  public function handle()
  {

    if (
      request()->is('api/*') ||
      \App::runningInConsole() === true ||
      !\Schema::hasTable('menu__menus')
    ) {
      return;
    }
    
    $menu = app(MenuRepository::class);
    $menuItem = app(MenuItemRepository::class);
    
    foreach ($menu->allOnline() as $menu) {
      
      $menuTree = $menuItem->getTreeForMenu($menu->id);
      
      MenuFacade::create($menu->name, function (Builder $menu) use ($menuTree) {
        foreach ($menuTree as $menuItem) {
          $this->addItemToMenu($menuItem, $menu);
        }
      });
    }
    
  }
  
  /**
   * Add a menu item to the menu
   * @param Menuitem $item
   * @param Builder $menu
   */
  public function addItemToMenu(Menuitem $item, Builder $menu)
  {
    if ($this->hasChildren($item)) {
      $this->addChildrenToMenu(
        $item->title,
        $item->items,
        $menu,
        [
          'id' => $item->id,
          'organization_id' => $item->organization_id,
          'icon' => $item->icon,
          'target' => $item->target,
          'class' => $item->class,
        ]
      );
    } else {
      $localisedUri = ltrim(parse_url(LaravelLocalization::localizeURL($item->uri), PHP_URL_PATH), '/');
      $target = $item->link_type != 'external' ? $localisedUri : $item->url;
    
      $menu->url(
        $target,
        $item->title,
        [
          'id' => $item->id,
          'organization_id' => $item->organization_id,
          'target' => $item->target,
          'icon' => $item->icon,
          'class' => $item->class,
        ]
      );
    }
  }
  
  /**
   * Add children to menu under the give name
   *
   * @param string $name
   * @param object $children
   * @param Builder|MenuItem $menu
   */
  private function addChildrenToMenu($name, $children, $menu, $attribs = [])
  {
    $menu->dropdown($name, function (PingpongMenuItem $subMenu) use ($children) {
      foreach ($children as $child) {
        $this->addSubItemToMenu($child, $subMenu);
      }
    }, 0, $attribs);
  }
  
  /**
   * Add children to the given menu recursively
   * @param Menuitem $child
   * @param PingpongMenuItem $sub
   */
  private function addSubItemToMenu(Menuitem $child, PingpongMenuItem $sub)
  {
    if ($this->hasChildren($child)) {
      $this->addChildrenToMenu($child->title, $child->items, $sub);
    } else {
      $target = $child->link_type != 'external' ? $child->locale . '/' . $child->uri : $child->url;
      $sub->url($target, $child->title, 0, ['icon' => $child->icon, 'target' => $child->target, 'class' => $child->class]);
    }
  }
  
  /**
   * Check if the given menu item has children
   *
   * @param object $item
   * @return bool
   */
  private function hasChildren($item)
  {
    return $item->items->count() > 0;
  }
}
