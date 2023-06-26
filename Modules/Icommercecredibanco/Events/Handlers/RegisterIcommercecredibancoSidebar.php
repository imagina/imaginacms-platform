<?php

namespace Modules\Icommercecredibanco\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommercecredibancoSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
        //$sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @return Menu
     */
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('icommercecredibanco::icommercecredibancos.title.icommercecredibancos'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                    /* append */
                );
                $item->item(trans('icommercecredibanco::icommercecredibancos.title.icommercecredibancos'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommercecredibanco.icommercecredibanco.create');
                    $item->route('admin.icommercecredibanco.icommercecredibanco.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommercecredibanco.icommercecredibancos.index')
                    );
                });
                $item->item(trans('icommercecredibanco::transactions.title.transactions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommercecredibanco.transaction.create');
                    $item->route('admin.icommercecredibanco.transaction.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommercecredibanco.transactions.index')
                    );
                });
                // append
            });
        });

        return $menu;
    }
}
