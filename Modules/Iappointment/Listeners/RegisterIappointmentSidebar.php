<?php

namespace Modules\Iappointment\Listeners;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIappointmentSidebar implements \Maatwebsite\Sidebar\SidebarExtender
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
            $group->item(trans('iappointment::iappointments.title.iappointments'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('iappointment::appointments.title.appointments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.appointment.create');
                    $item->route('admin.iappointment.appointment.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.appointments.index')
                    );
                });
                $item->item(trans('iappointment::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.category.create');
                    $item->route('admin.iappointment.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.categories.index')
                    );
                });
                $item->item(trans('iappointment::appointmentfields.title.appointmentfields'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.appointmentfield.create');
                    $item->route('admin.iappointment.appointmentfield.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.appointmentfields.index')
                    );
                });
                $item->item(trans('iappointment::appointmentstatuses.title.appointmentstatuses'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.appointmentstatus.create');
                    $item->route('admin.iappointment.appointmentstatus.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.appointmentstatuses.index')
                    );
                });
                $item->item(trans('iappointment::categoryforms.title.categoryforms'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.categoryform.create');
                    $item->route('admin.iappointment.categoryform.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.categoryforms.index')
                    );
                });
                $item->item(trans('iappointment::providers.title.providers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.iappointment.provider.create');
                    $item->route('admin.iappointment.provider.index');
                    $item->authorize(
                        $this->auth->hasAccess('iappointment.providers.index')
                    );
                });
// append






            });
        });

        return $menu;
    }
}
