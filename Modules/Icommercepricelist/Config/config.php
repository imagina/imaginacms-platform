<?php

return [
    'name' => 'Icommercepricelist',
    /**
     * @note routeName param must be set without locale. Ex: (icommerce orders: 'icommerce.store.order.index')
     * use **onlyShowInTheDropdownHeader** (boolean) if you want the link only appear in the dropdown in the header
     * use **onlyShowInTheMenuOfTheIndexProfilePage** (boolean) if you want the link only appear in the dropdown in the header
     */
    "userMenuLinks" => [
        [
            "title" => "icommercepricelist::pricelists.title.pricelists",
            "routeName" => "icommercepricelist.pricelists.index",
            "icon" => "fa fa-list",
        ],
    ],
];
