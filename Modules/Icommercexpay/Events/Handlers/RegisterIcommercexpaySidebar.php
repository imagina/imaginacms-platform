<?php

namespace Modules\Icommercexpay\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommercexpaySidebar implements \Maatwebsite\Sidebar\SidebarExtender
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

    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('icommercexpay::icommercexpays.title.icommercexpays'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icommercexpay::icommercexpays.title.icommercexpays'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommercexpay.icommercexpay.create');
                    $item->route('admin.icommercexpay.icommercexpay.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommercexpay.icommercexpays.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
