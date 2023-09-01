<?php

namespace Modules\Iplan\View\Components;

use Illuminate\View\Component;
use Modules\Iplan\Repositories\PlanRepository;

class PlanListItem extends Component
{
    public $view;

    public $item;

    public $price;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $layout = 'iplan-list-item-1')
    {
//    $this->item = $item;
        $this->item = $item;
        $this->view = 'iplan::frontend.components.plan-list-item.layout.'.($layout ?? 'iplan-list-item-1').'.index';
        $this->initCategories();
    }

    public function getParentAttributes($parentAttributes)
    {
        isset($parentAttributes['mediaImage']) ? $this->mediaImage = $parentAttributes['mediaImage'] : false;
    }

    private function makeParamsFunction()
    {
        return [
            'include' => $this->params['include'] ?? [],
            'take' => $this->params['take'] ?? 12,
            'page' => $this->params['page'] ?? 1,
            'filter' => $this->params['filter'] ?? [],
            'order' => $this->params['order'] ?? null,
        ];
    }

    /**
     * @return mixed
     */
    public function initCategories()
    {
        $this->categories = $this->categoryRepository()->getItemsBy(json_decode(json_encode(['include' => ['*'], 'take' => false])));
    }

    private function categoryRepository(): PlanRepository
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
