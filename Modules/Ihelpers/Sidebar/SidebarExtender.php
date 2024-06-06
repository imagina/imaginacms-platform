<?php

namespace Modules\Ihelpers\Sidebar;

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

            $group->item(trans('ihelpers::common.clearcache'), function (Item $item) {
                $item->icon('fa fa-eraser');
                $item->weight(-1);
                $item->route('admin.ihelpers.clearcache');
            });

            $group->item(trans('ihelpers::common.sitemapTitle'), function (Item $item) {
                $item->icon('fa fa-sitemap');
                $item->weight(200);
                $item->route('admin.ihelpers.sitemapGet');
            });

        });

        return $menu;
    }
}
