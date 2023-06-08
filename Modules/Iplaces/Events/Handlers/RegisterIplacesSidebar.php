<?php

namespace Modules\Iplaces\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIplacesSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('iplaces::common.iplaces'), function (Item $item) {
                $item->icon('fa fa-grav');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('iplaces.places.index')
                );
                $item->item(trans('iplaces::places.title.places'), function (Item $item) {
                    $item->icon('fa fa-grav');
                    $item->weight(0);
                    $item->append('admin.iplaces.place.create');
                    $item->route('admin.iplaces.place.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.places.index')
                    );
                });
                $item->item(trans('iplaces::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-puzzle-piece');
                    $item->weight(0);
                    $item->append('admin.iplaces.category.create');
                    $item->route('admin.iplaces.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.categories.index')
                    );
                });
                $item->item(trans('iplaces::services.title.services'), function (Item $item) {
                    $item->icon('fa fa-users');
                    $item->weight(0);
                    $item->append('admin.iplaces.service.create');
                    $item->route('admin.iplaces.service.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.services.index')
                    );
                });
                $item->item(trans('iplaces::zones.title.zones'), function (Item $item) {
                    $item->icon('fa fa-globe');
                    $item->weight(0);
                    $item->append('admin.iplaces.zone.create');
                    $item->route('admin.iplaces.zone.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.zones.index')
                    );
                });
                $item->item(trans('iplaces::schedules.title.schedules'), function (Item $item) {
                    $item->icon('fa fa-clock-o');
                    $item->weight(0);
                    $item->append('admin.iplaces.schedule.create');
                    $item->route('admin.iplaces.schedule.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.schedules.index')
                    );
                });
                $item->item(trans('iplaces::spaces.title.spaces'), function (Item $item) {
                    $item->icon('fa fa-square-o');
                    $item->weight(0);
                    $item->append('admin.iplaces.space.create');
                    $item->route('admin.iplaces.space.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.spaces.index')
                    );
                });

                $item->item(trans('iplaces::cities.title.cities'), function (Item $item) {
                    $item->icon('fa fa-exchange');
                    $item->weight(0);
                    $item->append('admin.iplaces.city.create');
                    $item->route('admin.iplaces.city.index');
                    $item->authorize(
                        $this->auth->hasAccess('iplaces.cities.index')
                    );
                });

            });
        });

        return $menu;
    }
}
