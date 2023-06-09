<?php

namespace Modules\Idocs\View\Components;

use Illuminate\View\Component;

class DocumentListItem extends Component
{
    public $item;

    public $layout;

    public $view;

    public $addToCartWithQuantity;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $layout = null,
                              $parentAttributes = null)
    {
        $this->item = $item;
        $this->layout = $layout;

        $this->view = 'idocs::frontend.components.document.document-list.layouts.'.($this->layout ?? 'document-list-layout-1').'.index';

        if (! empty($parentAttributes)) {
            $this->getParentAttributes($parentAttributes);
        }
    }

    private function getParentAttributes($parentAttributes)
    {
        isset($parentAttributes['itemListLayout']) ? $this->itemListLayout = $parentAttributes['itemListLayout'] : false;
    }

    private function getDocumentRepository()
    {
        return app('Modules\Idocs\Repositories\CategoryRepository');
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
