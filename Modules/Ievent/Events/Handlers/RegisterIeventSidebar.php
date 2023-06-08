<?php

namespace Modules\Ievent\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIeventSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('ievent::ievent.title.ievent'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('ievent::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.category.create');
                    $item->route('admin.ievent.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.categories.index')
                    );
                });
                $item->item(trans('ievent::recurrencedays.title.recurrencedays'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.recurrenceday.create');
                    $item->route('admin.ievent.recurrenceday.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.recurrencedays.index')
                    );
                });
                $item->item(trans('ievent::events.title.events'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.event.create');
                    $item->route('admin.ievent.event.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.events.index')
                    );
                });
                $item->item(trans('ievent::recurrences.title.recurrences'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.recurrence.create');
                    $item->route('admin.ievent.recurrence.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.recurrences.index')
                    );
                });
                $item->item(trans('ievent::attendants.title.attendants'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.attendant.create');
                    $item->route('admin.ievent.attendant.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.attendants.index')
                    );
                });
                $item->item(trans('ievent::comments.title.comments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.ievent.comment.create');
                    $item->route('admin.ievent.comment.index');
                    $item->authorize(
                        $this->auth->hasAccess('ievent.comments.index')
                    );
                });
// append






            });
        });

        return $menu;
    }
}
