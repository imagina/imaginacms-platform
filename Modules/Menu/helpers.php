<?php

if (! function_exists('getMenu')) {
    function getMenu($id)
    {
        $menuRepository = app('Modules\Menu\Repositories\MenuRepository');
        $params = json_decode(json_encode(['include' => ['menuitems']]));

        $menu = $menuRepository->getItem($id, $params);

        return $menu;
    }
}
