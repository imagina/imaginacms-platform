<?php

namespace Modules\Ilocations\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIlocationsSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('ilocations::common.title'), function (Item $item) {
                $item->icon('fa fa-globe');
                $item->weight(10);
                $item->item(trans('ilocations::geozones.title.geozones'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ilocations.geozones.create');
                    $item->route('admin.ilocations.geozones.index');
                    $item->authorize(
                        $this->auth->hasAccess('ilocations.geozones.index')
                    );
                });

                $item->authorize(
                    $this->auth->hasAccess('ilocations.geozones.index')

                );
            });
        });

        return $menu;
    }
}
