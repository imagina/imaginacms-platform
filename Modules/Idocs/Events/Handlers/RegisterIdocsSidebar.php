<?php

namespace Modules\Idocs\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIdocsSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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

    /**
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('idocs::common.title.idocs'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('idocs.categories.index') || $this->auth->hasAccess('idocs.documents.index') || $this->auth->hasAccess('idocs.documents.migrate')
                );
                $item->item(trans('idocs::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.idocs.category.create');
                    $item->route('admin.idocs.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('idocs.categories.index')
                    );
                });
                $item->item(trans('idocs::documents.title.documents'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.idocs.document.create');
                    $item->route('admin.idocs.document.index');
                    $item->authorize(
                        $this->auth->hasAccess('idocs.documents.index')
                    );
                });

                $item->item(trans('idocs::documents.title.import documents'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->route('admin.idocs.document.migrate');
                    $item->authorize(
                        $this->auth->hasAccess('idocs.documents.migrate')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
