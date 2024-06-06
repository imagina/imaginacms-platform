<?php

namespace Modules\Iprofile\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIprofileSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
  /**
   * @var Authentication
   */
  protected $auth;

  /**
   * @param Authentication $auth
   *
   * @internal param Guard $guard
   */
  public function __construct(Authentication $auth)
  {
    $this->auth = $auth;
  }

  public function handle(BuildingSidebar $sidebar)
  {
    $sidebar->add($this->extendWith($sidebar->getMenu()));
  }

  /**
   * @param Menu $menu
   * @return Menu
   */
  public function extendWith(Menu $menu)
  {
    $menu->group(trans('core::sidebar.content'), function (Group $group) {

    });

    return $menu;
  }
}
