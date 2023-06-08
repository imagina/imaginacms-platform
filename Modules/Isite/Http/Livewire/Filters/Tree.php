<?php

namespace Modules\Isite\Http\Livewire\Filters;

use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;

class Tree extends Component
{
  /*
* Attributes From Config
*/
  public $title;
  public $name;
  public $status;
  public $isExpanded;
  public $type;
  public $repository;
  public $emitTo;
  public $repoAction;
  public $repoAttribute;
  public $repoMethod;
  public $listener;
  public $layout;
  public $classes;
  public $renderMode;
  public $entityClass;
  public $params;
  
  
  protected $breadcrumb;
  public $typeTitle;
  protected $items;
  public $configs;
  public $itemSelected;
  public $initElements;
  
  public $extraParamsUrl;
  
  
  public function mount($title, $name, $type, $repository, $entityClass, $emitTo, $repoAction, $repoAttribute, $listener,
                        $repoMethod = "getItemsBy", $params = [], $layout = 'range-layout-1', $itemSelected = null,
                        $typeTitle = "configTitle", $classes = 'col-12', $status = true, $isExpanded = true,
                        $breadcrumb = [], $renderMode = "allTree")
  {
    $this->title = trans($title);
    $this->name = $name;
    $this->status = $status;
    $this->isExpanded = $isExpanded;
    $this->type = $type;
    $this->repository = $repository;
    $this->entityClass = $entityClass;
    $this->emitTo = $emitTo;
    $this->repoAction = $repoAction;
    $this->repoAttribute = $repoAttribute;
    $this->repoMethod = $repoMethod ?? "getItemsBy";
    $this->listener = $listener;
    $this->layout = $layout;
    $this->classes = $classes;
    $this->renderMode = $renderMode;
    $this->params = $params;
    $this->initElements = [];
    
    $this->breadcrumb = $breadcrumb ?? [];
    $this->extraParamsUrl = "";
    
    $this->itemSelected = $itemSelected;
    $this->typeTitle = $typeTitle;

    if ($this->typeTitle == "itemSelected" && isset($this->itemSelected))
      $this->title = $this->itemSelected->title ?? $this->itemSelected->name ?? $this->title;
    
    
    $this->initConfigs();
    
  }
  
  
  /*
  * Init Configs to ProductList
  *
  */
  public function initConfigs()
  {
    
    $this->configs = config("asgard.icommerce.config.filters.categories");
    
  }
  
  public function updateItemSelected($item)
  {
    
    if (!empty($this->emitTo)) {
      $this->itemSelected = $this->getRepository()->getItem($item, json_decode(json_encode(["filter" => ["field" => "id"]])));
  
      
      $this->refreshBreadcrumb();
      
      $this->emit($this->emitTo, [
        $this->repoAction => [
          $this->repoAttribute => $item
        ]
      ]);
    }
    
    
  }
  
  /*
  * Get Listener From Config
  *
  */
  protected function getListeners()
  {
    if (!empty($this->listener)) {
      $listener = [$this->listener => 'getData',
        'updateItemSelected'];
    } else {
      $listener = [
        'updateItemSelected'
      ];
    }
    
    return $listener;
  }
  
  
  private function getRepository()
  {
    return app($this->repository);
  }
  
  private function refreshBreadcrumb()
  {
    if (isset($this->itemSelected->id)) {
      $this->breadcrumb = $this->entityClass::ancestorsAndSelf($this->itemSelected->id);
    } else {
      $this->breadcrumb = [];
    }
  }
  
  /*
    * Listener
    * Item List Rendered (Like First Version)
    */
  public function getData($params)
  {
    
    $params = json_decode(json_encode([
      "include" => ['translations'],
      "take" => null,
      "filter" => $this->params["filter"] ?? []
    ]));
    
    $this->refreshBreadcrumb();
    
    $this->items = $this->getRepository()->{$this->repoMethod}($params);
    
    
    // Reorganize collection by the 'mode' config
    if (isset($this->itemSelected->id) && $this->renderMode) {
      switch ($this->renderMode) {
        case 'allFamilyOfTheSelectedNode':
          $ancestors = $this->entityClass::ancestorsAndSelf($this->itemSelected->id)->where("status",1);
          $rootItem = $ancestors->whereNull('parent_id')->first();
          $this->items = $this->entityClass::descendantsAndSelf($rootItem->id)->where("status",1);
          break;
        
        case 'onlyLeftAndRightOfTheSelectedNode':
          $ancestors = $this->entityClass::ancestorsOf($this->itemSelected->id)->where("status",1);
          $descendants = $result = $this->entityClass::descendantsAndSelf($this->itemSelected->id)->where("status",1);
          $siblings = $this->itemSelected->getSiblings()->where("status",1);
          $this->items = $ancestors->merge($descendants)->merge($siblings);
          break;

      }
    }
  
    if($this->items->isNotEmpty())
      $this->items = $this->items->toTree();
    
    //dd($this->items);
  }
  
  public function render()
  {
  
    $this->getData($this->params);
    
    $tpl = 'isite::frontend.livewire.filters.tree.index';
    $ttpl = 'isite.livewire.filters.tree.index';
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    return view($tpl, ["breadcrumb" => $this->breadcrumb]);
    
  }
  
  
}