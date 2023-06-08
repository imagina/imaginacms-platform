<?php

namespace Modules\Ipay\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\User\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
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

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {

            $group->item(trans('ipay::common.ipay'), function (Item $item) {

                 $item->item(trans('ipay::config.edit'), function (Item $item) {
                    $item->icon('fa fa-list');
                    $item->weight(5);
                    $item->route('admin.ipay.config.index');
                    $item->authorize(
                        $this->auth->hasAccess('ipay.config.index')
                    );
                });


            });


        });

        return $menu;
    }
}
