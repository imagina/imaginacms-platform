<?php

namespace Modules\Iappointment\View\Components;

use Illuminate\View\Component;
use Modules\Iappointment\Repositories\CategoryRepository;

class CategoryListItem extends Component
{

    public $view;
    public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $layout = 'category-list-item-1')
    {
        $this->item = $item;
        $this->view = "iappointment::frontend.components.category-list-item.layout.". ( $layout ?? 'category-list-item-1').".index";
    }


    function getParentAttributes($parentAttributes)
    {
        isset($parentAttributes["mediaImage"]) ? $this->mediaImage = $parentAttributes["mediaImage"] : false;

    }

    private function makeParamsFunction(){

        return [
            "include" => $this->params["include"] ?? [],
            "take" => $this->params["take"] ?? 12,
            "page" => $this->params["page"] ?? 1,
            "filter" => $this->params["filter"] ?? [],
            "order" => $this->params["order"] ?? null
        ];
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view($this->view);
    }
}
