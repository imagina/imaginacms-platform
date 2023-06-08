<?php

namespace Modules\Iplan\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIplanSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('iplan::iplan.title.iplan'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('iplan::plans.title.plans'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iplan.plan.create');
                    $item->route('admin.iplan.plan.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplan.plans.index')
                    );
                });
                $item->item(trans('iplan::limits.title.limits'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iplan.limit.create');
                    $item->route('admin.iplan.limit.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplan.limits.index')
                    );
                });
                $item->item(trans('iplan::planusers.title.planusers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iplan.planuser.create');
                    $item->route('admin.iplan.planuser.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplan.planusers.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
