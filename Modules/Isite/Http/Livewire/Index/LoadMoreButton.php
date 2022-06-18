<?php

namespace Modules\Isite\Http\Livewire\Index;

use Livewire\Component;
use Livewire\WithPagination;
use App;

use Illuminate\Http\Request;

class LoadMoreButton extends Component
{

  use WithPagination;

  public $entityName;
  public $itemComponentNamespace;
  public $itemComponentName;
  public $itemComponentAttributes;
  public $layoutClass;
  public $itemListLayout;
  public $repository;
  public $params;
  public $pagination;
  public $itemMainClass;
  public $itemModal;
  public $infiniteStatus;

  /**
   * Attributes
   */
  public $loadMore;
  public $showBtnLoadMore;
  public $editLink;
  public $tooltipEditLink;

  /**
   * Listeners
   */
  protected $listeners = [
    'loadMoreButtonInfinite' => 'loadMoreInfinite',
    'loadMoreButtonUpdateParamsForFilters' => 'updateParamsForFilters'
  ];

  /*
  * Runs once, immediately after the component is instantiated,
  * but before render() is called
  */
  public function mount($entityName,$itemComponentNamespace,$itemComponentName,$itemComponentAttributes,$layoutClass,$itemListLayout,$repository,$params,$pagination,$itemMainClass,$itemModal,$editLink,$tooltipEditLink,$parentItemListUniqueClass)
  {

    $this->entityName = $entityName;
    $this->itemComponentNamespace = $itemComponentNamespace;
    $this->itemComponentName = $itemComponentName;
    $this->itemComponentAttributes = $itemComponentAttributes;
    $this->itemModal = $itemModal;

    $this->layoutClass = $layoutClass;
    $this->itemListLayout = $itemListLayout;
    $this->repository = $repository;
    $this->params = $params;
    $this->itemMainClass = $itemMainClass;
    $this->pagination = $pagination;

    $this->loadMore = false;
    $this->showBtnLoadMore = true; 
    $this->infiniteStatus = false;
    
    $this->editLink = $editLink;
    $this->tooltipEditLink = $tooltipEditLink;

    $this->parentItemListUniqueClass = $parentItemListUniqueClass;
    
  }

  /*
  * Action
  * Btn load more
  */
  public function loadMore()
  {

    //\Log::info("Load More Button - GETDATA - PARAMS: ".json_encode($this->params));

    $this->params["page"] = $this->params["page"] + 1;
    $this->loadMore = true;

    $items = $this->getItemRepository()->getItemsBy(json_decode(json_encode($this->params)));

    if(!$items->hasMorePages())
      $this->showBtnLoadMore = false;
     
    $newHtml = view('isite::frontend.livewire.index.partials.items', [
      'items' => $items,
      'layoutClass' => $this->layoutClass,
      'entityName' => $this->entityName,
      'itemComponentNamespace' => $this->itemComponentNamespace,
      'itemComponentAttributes' => $this->itemComponentAttributes,
      'itemComponentName' => $this->itemComponentName,
      'itemMainClass' => $this->itemMainClass,
      'editLink' => $this->editLink,
      'tooltipEditLink' => $this->tooltipEditLink,
      'itemModal' => $this->itemModal,
      'itemListLayout' => $this->itemListLayout
    ])->render();
    
    $this->dispatchBrowserEvent('items-load-more-button', [
      'newHtml' => $newHtml  
    ]);
    
  }

  /*
  * Listener
  * Emited Frontend
  */
  public function loadMoreInfinite(){

    //if(!$this->infiniteStatus){

      //\Log::info("LLama a LoadMore");

      $this->infiniteStatus = true;
      $this->loadMore();
    //}

  }

  /*
  * Listener
  * Emited By Items Lists when update a Filter
  */
  public function updateParamsForFilters($newParams,$showMore){
    
    //\Log::info("Load More Button - Update Params: ".json_encode($newParams));
    //\Log::info("Load More Button - showMore: ".$showMore);

    $this->params = $newParams;
    $this->showBtnLoadMore = $showMore;

  }
  
 /*
 * Get Item Repository
 *
 */
  private function getItemRepository(){
    return app($this->repository);
  }
  
  /*
  * Render
  *
  */
  public function render()
  {

    $view = 'isite::frontend.livewire.index.load-more-button';
    return view($view);

  }

}