<?php

namespace Modules\Iblog\View\Components;

use Illuminate\View\Component;

class Timeline extends Component
{
    public $view;

    public $items;

    public $params;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($layout = 'timeline-layout-1', $params = [])
    {
        $this->view = "iblog::frontend.components.timeline.layouts.$layout.index";
        $this->params = $params;

        $this->getItems();
    }

    private function getItems()
    {
        $repository = app("Modules\Iblog\Repositories\PostRepository");

        $this->items = $repository->getItemsBy(json_decode(json_encode($this->params)));
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
