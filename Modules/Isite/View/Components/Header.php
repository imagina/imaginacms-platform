<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $items;

    public $view;

    public $itemLayout;

    public $components;

    public $layout;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($components = [
        'headerMenu' => [
            'repository' => "Modules\Icommerce\Repositories\CategoryRepository",
            'id' => 'menuCat',
        ],
    ], $layout = 'header-layout-1'
  ) {
        $this->components = $components;

        $this->view = "isite::frontend.components.header.layouts.{$layout}.index";
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
