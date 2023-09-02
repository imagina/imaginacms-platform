<?php

namespace Modules\Notification\Events\Handlers;

use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterNotificationSidebar extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     */
    public function extendWith(\Maatwebsite\Sidebar\Menu $menu)
    {
        return $menu;
    }
}
