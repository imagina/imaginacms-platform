<?php

namespace Modules\Icommercepaymentez\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommercepaymentezSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        //$sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @return Menu
     */
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('icommercepaymentez::icommercepaymentezs.title.icommercepaymentezs'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icommercepaymentez::icommercepaymentezs.title.icommercepaymentezs'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommercepaymentez.icommercepaymentez.create');
                    $item->route('admin.icommercepaymentez.icommercepaymentez.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommercepaymentez.icommercepaymentezs.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
