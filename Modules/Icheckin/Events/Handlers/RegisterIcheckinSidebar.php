<?php

namespace Modules\Icheckin\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcheckinSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('icheckin::icheckins.title.icheckins'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icheckin::jobs.title.jobs'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icheckin.job.create');
                    $item->route('admin.icheckin.job.index');
                    $item->authorize(
                        $this->auth->hasAccess('icheckin.jobs.index')
                    );
                });
                $item->item(trans('icheckin::requests.title.requests'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icheckin.request.create');
                    $item->route('admin.icheckin.request.index');
                    $item->authorize(
                        $this->auth->hasAccess('icheckin.requests.index')
                    );
                });
                $item->item(trans('icheckin::shifts.title.shifts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icheckin.shift.create');
                    $item->route('admin.icheckin.shift.index');
                    $item->authorize(
                        $this->auth->hasAccess('icheckin.shifts.index')
                    );
                });

                $item->item(trans('icheckin::approvals.title.approvals'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icheckin.approval.create');
                    $item->route('admin.icheckin.approval.index');
                    $item->authorize(
                        $this->auth->hasAccess('icheckin.approvals.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
