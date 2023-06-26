<?php

namespace Modules\Icommercefreeshipping\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommercefreeshippingSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icommercefreeshipping::icommercefreeshippings.title.icommercefreeshippings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommercefreeshipping.icommercefreeshipping.create');
                    $item->route('admin.icommercefreeshipping.icommercefreeshipping.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommercefreeshipping.icommercefreeshippings.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
