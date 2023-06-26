<?php

namespace Modules\Iad\View\Components;

use Illuminate\View\Component;

class UpListItem extends Component
{
    public $view;

    public $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $mediaImage = 'mainimage', $layout = 'up-list-item-1',
                              $wishlist = true, $city = true, $years = true,
                              $price = true, $pais = true, $likes = true, $numberComments = true)
    {
        $this->mediaImage = $mediaImage;
        $this->item = $item;
        $this->view = 'iad::frontend.components.up-list-item.layout.'.($layout ?? '.up-list-item-1').'.index';
    }

    /**
     * @return currencyRepository
     */
    private function categoryRepository(): currencyRepository
    {
        return app('Modules\Iad\Repositories\CategoryRepository');
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
