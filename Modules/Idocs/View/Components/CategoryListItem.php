<?php

namespace Modules\Idocs\View\Components;

use Illuminate\View\Component;

class CategoryListItem extends Component
{
  
  
  public $item;
  public $layout;
  public $view;
  public $documents;
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
    
    $this->view = "idocs::frontend.components.category.category-list.layouts." . ($this->layout ?? "category-list-layout-1") . ".index";
    
    if (!empty($parentAttributes))
      $this->getParentAttributes($parentAttributes);
  
    $params = [
                    'filter' => ['categoryId' => $item->id],
                    'include' => [],
                    'take' => 12
                  ];
    $this->documents = $this->getDocumentRepository()->getItemsBy(json_decode(json_encode($params)));
  }
  
  private function getParentAttributes($parentAttributes)
  {
    
    isset($parentAttributes["itemListLayout"]) ? $this->itemListLayout = $parentAttributes["itemListLayout"] : false;
    
  }
  
  private function getDocumentRepository()
  {
    return app('Modules\Idocs\Repositories\DocumentRepository');
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