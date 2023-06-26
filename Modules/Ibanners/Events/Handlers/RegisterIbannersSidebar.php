<?php

namespace Modules\Ibanners\Events\Handlers;

use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\Ibanners\Repositories\PositionRepository;
use Modules\User\Contracts\Authentication;

class RegisterIbannersSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('ibanners::common.title'), function (Item $item) {
                $item->weight(3);
                $item->icon('fa fa-window-restore');
                $item->route('admin.ibanners.position.index');
                $item->badge(function (Badge $badge, PositionRepository $positionRepository) {
                    $badge->setClass('bg-green');
                    $badge->setValue($positionRepository->countAll());
                });
                $item->authorize(

                );
            });
        });

        return $menu;
    }
}
