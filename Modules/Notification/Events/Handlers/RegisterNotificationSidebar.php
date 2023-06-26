<?php

namespace Modules\Notification\Events\Handlers;

use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterNotificationSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     *
     *
     * @return \Maatwebsite\Sidebar\Menu
     */
    public function extendWith(\Maatwebsite\Sidebar\Menu $menu): Menu
    {
        return $menu;
    }
}
