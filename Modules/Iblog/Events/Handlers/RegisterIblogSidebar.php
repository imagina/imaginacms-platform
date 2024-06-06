<?php

namespace Modules\Iblog\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIblogSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('iblog::common.iblog'), function (Item $item) {
                $item->icon('fa fa-copy');

                $item->item(trans('iblog::category.list'), function (Item $item) {
                    $item->icon('fa fa-file-text');
                    $item->weight(5);
                    $item->append('admin.iblog.category.create');
                    $item->route('admin.iblog.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('iblog.categories.create')
                    );
                });

                $item->item(trans('iblog::post.list'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(5);
                    $item->append('admin.iblog.post.create');
                    $item->route('admin.iblog.post.index');
                    $item->authorize(
                        $this->auth->hasAccess('iblog.posts.index')
                    );
                });

                $item->authorize(
                    $this->auth->hasAccess('iblog.posts.index')  || $this->auth->hasAccess('iblog.categories.index')
                );

            });
        });

        return $menu;
    }
}
