<?php

namespace Modules\Icommerceagree\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommerceagreeSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('icommerceagree::icommerceagrees.title.icommerceagrees'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icommerceagree::icommerceagrees.title.icommerceagrees'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerceagree.icommerceagree.create');
                    $item->route('admin.icommerceagree.icommerceagree.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerceagree.icommerceagrees.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
