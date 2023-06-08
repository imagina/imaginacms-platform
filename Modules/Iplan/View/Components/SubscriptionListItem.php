<?php

namespace Modules\Iplan\View\Components;

use Illuminate\View\Component;
use Modules\Iplan\Repositories\PlanRepository;

class SubscriptionListItem extends Component
{

    public $view;
    public $item;
    public $formatCreatedDate;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $layout = 'subscription-list-item-1', $formatCreatedDate = "d \\d\\e M", $parentAttributes = null)
    {
//    $this->item = $item;
        $this->item = $item;
        $this->view = "iplan::frontend.components.subscription-list-item.layout.". ( $layout ?? 'subscription-list-item-1').".index";
        $this->formatCreatedDate = $formatCreatedDate;

        if(!empty($parentAttributes))
            $this->getParentAttributes($parentAttributes);
    }


    function getParentAttributes($parentAttributes)
    {
        isset($parentAttributes["mediaImage"]) ? $this->mediaImage = $parentAttributes["mediaImage"] : false;
        isset($parentAttributes["formatCreatedDate"]) ? $this->formatCreatedDate = $parentAttributes["formatCreatedDate"] : false;

    }

    private function makeParamsFunction()
    {

        return [
            "include" => $this->params["include"] ?? [],
            "take" => $this->params["take"] ?? 12,
            "page" => $this->params["page"] ?? 1,
            "filter" => $this->params["filter"] ?? [],
            "order" => $this->params["order"] ?? null
        ];
    }


    /**
     * @return PlanRepository
     */
    private function categoryRepository()
    {
        return app('Modules\Iplan\Repositories\CategoryRepository');
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
