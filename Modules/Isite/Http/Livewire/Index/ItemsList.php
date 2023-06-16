<?php

namespace Modules\Isite\Http\Livewire\Index;

use App;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class ItemsList extends Component
{
    use WithPagination;

    private $firstRequest;

    public $title;

    public $description;

    public $moduleName;

    public $repository;

    public $itemComponentName;

    public $entityName;

    public $responsiveTopContent;

    public $itemModal;

    public $itemMainClass;

    public $totalItems = 0;

    public $search = '';

    private $order;

    // OrderBy to URL
    public $orderBy;

    public $configs;

    public $itemListLayout;

    public $layoutClass;

    public $wrapperClass;

    public $pagination;

    public $showTitle;

    public $amount;

    public $itemComponentAttributes;

    public $itemComponentNamespace;

    public $carouselAttributes;

    public $take;

    public $moduleParams = [];

    public $filter = [];

    public $editLink = '';

    public $tooltipEditLink = '';

    public $uniqueItemListRendered;

    public $emitItemListRenderedName;

    public $disableFilters;

    //Item List Unique Class
    public $itemListUniqueClass;

    protected $paginationTheme = 'bootstrap';

    protected $emitItemListRendered;

    /**
     * Listeners
     */
    protected $listeners = [
        'itemsListGetData' => 'getData',
        'itemsListClearValues' => 'clearValues',
    ];

    /**
     * Query String
     */
    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => []],
        'page' => ['except' => 1],
    ];

    /*
      * Runs once, immediately after the component is instantiated,
      * but before render() is called
      */
    public function mount(
    $itemComponentNamespace = "Modules\Isite\View\Components\ItemList", $itemListLayout = null, $moduleName = 'isite',
    $entityName = 'item', $itemComponentName = 'isite::item-list', $params = [], $responsiveTopContent = null,
    $showTitle = true, $pagination = null, $configOrderBy = null, $configLayoutIndex = null, $itemComponentAttributes = [],
    $itemModal = null, $carouselAttributes = null, $uniqueItemListRendered = false, $title = null, $description = null,
    $disableFilters = false
  ) {
        $this->moduleName = strtolower($moduleName);
        $this->entityName = strtolower($entityName);
        $customIndexTitle = setting($moduleName.'::customIndexTitle');
        $this->title = ! empty($title) ? $title : (! empty($customIndexTitle) ? $customIndexTitle : trans($this->moduleName.'::frontend.index.title'));
        $customIndexDescription = setting($moduleName.'::customIndexDescription');
        $this->description = ! empty($description) ? $description : (! empty($customIndexDescription) ? $customIndexDescription : '');
        $this->itemComponentName = $itemComponentName;
        $this->itemComponentAttributes = $itemComponentAttributes;
        $this->itemComponentNamespace = $itemComponentNamespace;
        $this->itemMainClass = $this->entityName == 'ad' ? 'pin' : $this->entityName;
        $this->repository = 'Modules\\'.ucfirst($this->moduleName)."\Repositories\\".ucfirst($entityName).'Repository';
        $this->moduleParams = $params;
        $this->page = $this->moduleParams['page'] ?? 1;
        $this->take = $this->moduleParams['take'] ?? 12;
        $this->responsiveTopContent = $responsiveTopContent ?? ['mobile' => true, 'desktop' => true, 'order' => true];
        $this->showTitle = $showTitle;
        $this->pagination = $pagination ? array_merge(['show' => true, 'type' => 'normal'], $pagination) : ['show' => true, 'type' => 'normal'];
        $this->itemModal = $itemModal ?? ['mobile' => false, 'desktop' => false, 'idModal' => 'modal_'.$this->id];
        $this->carouselAttributes = $carouselAttributes;
        $this->uniqueItemListRendered = $uniqueItemListRendered;
        $this->initConfigs($configOrderBy, $configLayoutIndex);
        $this->initValuesOrderBy();
        $this->initValuesLayout($itemListLayout);
        $this->initRequest();
        $this->validateNameEmitListRendered();
        [$this->editLink, $this->tooltipEditLink] = getEditLink($this->repository);

        $this->itemListUniqueClass = 'unique-class-'.$this->id;
        $this->disableFilters = $disableFilters;
    }

    /*
    * Init Configs
    *
    */
    public function initConfigs($configOrderBy, $configLayoutIndex)
    {
        $this->configs['orderBy'] = $configOrderBy ?? config('asgard.isite.config.orderBy');
        $this->configs['itemListLayout'] = $configLayoutIndex ?? config('asgard.isite.config.layoutIndex');
    }

    /*
    * Init Values Orderby
    *
    */
    public function initValuesOrderBy()
    {
        // OrderBy to URL
        $this->orderBy = $this->configs['orderBy']['default'] ?? 'nameaz';
        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];
    }

    /*
    * Init Values To ChangeLayout
    *
    */
    public function initValuesLayout($itemListLayout)
    {
        $this->itemListLayout = $itemListLayout ?? $this->configs['itemListLayout']['default'] ?? 'four';
        $this->layoutClass = $this->configs['itemListLayout']['options'][$this->itemListLayout]['class'];
        ! is_array($this->layoutClass) ? $this->layoutClass = [$this->layoutClass] : false;
        $this->wrapperClass = $this->configs['itemListLayout']['options'][$this->itemListLayout]['wrapperClass'] ?? 'row';
    }

    /*
    * Listener - GET DATA FROM FILTERS
    *
    */
    public function getData($params)
    {
        //\Log::info("ITEMLIST - GETDATA - PARAMS: ".json_encode($params));
        if (isset($params['filter'])) {
            $this->emitItemListRendered = true;
            if (! $this->disableFilters) {
                $this->filter = array_merge($this->filter, $params['filter']);
            }

            $this->resetPage();
        }
        if (isset($params['order'])) {
            $this->emitItemListRendered = false;
            $this->orderBy = $params['order'];
            $this->resetPage();
        }
    }

    /*
    * Init Request
    *
    */
    public function initRequest()
    {
        $this->firstRequest = true;
        $this->emitItemListRendered = false;
        $this->fill(request()->only('search', 'filter', 'page', 'orderBy'));
    }

    /*
    * Function Frontend - When change the layout
    *
    */
    public function changeLayout($c)
    {
        $this->itemListLayout = $c;
        $this->layoutClass = $this->configs['itemListLayout']['options'][$this->itemListLayout]['class'];
        ! is_array($this->layoutClass) ? $this->layoutClass = [$this->layoutClass] : false;
    }

    /*
    * Listener
    * Clear Values
    */
    public function clearValues()
    {
        //\Log::info($this->name."- CLEAR VALUES FILTER");
        $this->filter = [];
        $this->emitItemListRendered = true;
    }

    /*
    * Function Frontend - Load More Button
    *
    */
    public function loadMore()
    {
        $this->take += $this->moduleParams['take'];
    }

    /*
 * Make params to Repository
 * before execcute the query
 */
    public function makeParamsToRepository()
    {
        if ($this->firstRequest) {
            $this->firstRequest = false;
        }
        // To First Time and Others
        $this->order = $this->configs['orderBy']['options'][$this->orderBy]['order'];
        if (is_string($this->search) && $this->search) {
            $this->filter['search'] = $this->search;
            $this->filter['locale'] = App::getLocale();
        }
        $params = [
            'include' => $this->moduleParams['include'] ?? [],
            'take' => $this->take,
            'page' => $this->page,
            'filter' => $this->filter,
            'order' => $this->order,
            'fields' => $this->moduleParams['fields'] ?? null,
        ];
        if (isset($this->moduleParams['filter']) && ! empty($this->moduleParams['filter'])) {
            $params['filter'] = array_merge_recursive($params['filter'], $this->moduleParams['filter']);
        }

        return $params;
    }

    /*
    * Get Item Repository
    *
    */
    private function getItemRepository()
    {
        return app($this->repository);
    }

    /*
    * Validate Name Emit List Rendered
    * To Frontend multiples components
    */
    private function validateNameEmitListRendered()
    {
        $this->emitItemListRenderedName = 'itemListRendered';
        if ($this->uniqueItemListRendered) {
            $this->emitItemListRenderedName = 'itemListRendered_'.$this->id;
        }
    }

    /*
    * Render
    *
    */
    public function render()
    {
        if (! $this->firstRequest && ! in_array('orderBy', $this->queryString)) {
            array_push($this->queryString, 'orderBy');
        }
        $params = $this->makeParamsToRepository();
        //\Log::info("ITEM LIST - RENDER - PARAMS QUERY ".json_encode($params));
        $items = $this->getItemRepository()->getItemsBy(json_decode(json_encode($params)));
        $this->totalItems = method_exists($items, 'total') ? $items->total() : $items->count();
        //\Log::info("ITEM LIST - TOTAL: ".$items->total());
        $tpl = 'isite::frontend.livewire.index.items-list';
        // Add value name to order on Filter
        $params['orderBy'] = $this->orderBy;
        // Update Params in other component when init a Filter
        if ($this->pagination['type'] == 'infiniteScroll') {
            $showMore = $items->hasMorePages() ? true : false;
            $this->emit('loadMoreButtonUpdateParamsForFilters', $params, $showMore);
        }
        // Emit Finish Render
        //\Log::info("Emit list rendered: ".json_encode($this->emitItemListRendered));
        $this->emitItemListRendered ? $this->emit($this->emitItemListRenderedName, $params) : false;

        return view($tpl, ['items' => $items, 'params' => $params]);
    }
}
