<?php

namespace Modules\Iad\View\Components;

use Illuminate\View\Component;

class ListItem extends Component
{
    public $view;

    public $embedded;

    public $item;

    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $mediaImage = 'mainimage', $layout = 'iad-list-item-1',
                              $wishlist = true, $city = true, $years = true,
                              $price = true, $pais = true, $likes = true, $numberComments = true, $embedded = false)
    {
//    $this->item = $item;
        $this->mediaImage = $mediaImage;
        $this->item = $item;
        $this->embedded = $embedded;
        $this->view = 'iad::frontend.components.list-item.layout.'.($layout ?? '.iad-list-item-1').'.index';
        //$this->initCategories();
    }

    /**
     * @return mixed
     */
    public function initCategories()
    {
        $this->categories = $this->categoryRepository()->getItemsBy(json_decode(json_encode([])));
    }

    /**
     * @return currencyRepository
     */
    private function categoryRepository()
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
