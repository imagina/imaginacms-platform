<?php

namespace Modules\Iforms\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIformsSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('iforms::common.iforms'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('iforms::forms.title.forms'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iforms.form.create');
                    $item->route('admin.iforms.form.index');
                    $item->authorize(
                        $this->auth->hasAccess('iforms.forms.index')
                    );
                });
                $item->item(trans('iforms::fields.title.fields'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iforms.field.create');
                    $item->route('admin.iforms.field.index');
                    $item->authorize(
                        $this->auth->hasAccess('iforms.fields.index')
                    );
                });
                $item->item(trans('iforms::leads.title.leads'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iforms.lead.create');
                    $item->route('admin.iforms.lead.index');
                    $item->authorize(
                        $this->auth->hasAccess('iforms.leads.index')
                    );
                });
// append



            });
        });

        return $menu;
    }
}
