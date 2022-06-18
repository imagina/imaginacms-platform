<?php

namespace Modules\Isite\Http\Livewire;

use Livewire\Component;

class Filters extends Component
{

  public $filters;
  public $showResponsiveModal;
  public $showBtnFilter;
  public $showBtnClear;
  public $extraModalId;
  public $btnFilterLabel;
  public $goToUrl;
  public $view;

  public $filtersValues = [];

  /**
   * Listeners
   */
  protected $listeners = [
    'filtersGetData' => 'getDataFromFilters',
  ];


  /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
  public function mount($filters = null, $showResponsiveModal = true, $showBtnFilter = false, $showBtnClear = false,
                        $extraModalId = null, $goToUrl = false, $btnFilterLabel = null, $layout = 'filter-layout-1')
  {

    $this->filters = $filters;
    $this->showResponsiveModal = $showResponsiveModal;
    $this->showBtnFilter = $showBtnFilter;
    $this->showBtnClear = $showBtnClear;
    $this->extraModalId = $extraModalId;
    $this->btnFilterLabel = $btnFilterLabel;
    $this->goToUrl = $goToUrl;
    $this->view = "isite::frontend.livewire.filters-parent.layouts." . ($layout ?? 'filter-layout-1') . ".index";

  }


  /*
  * LISTENER
  */
  public function getDataFromFilters($params)
  {

    //\Log::info("FILTERS - GETDATA - PARAMS: ".json_encode($params));
    if (isset($params["goToUrl"])) {
      $this->goToUrl = $params["goToUrl"];
    }
    
    if (isset($params["filter"])) {

      $filterName = $params['name'];

      $this->filtersValues[$filterName] = $params["filter"];

      \Log::info("FILTER {$filterName}: " . json_encode($this->filtersValues[$filterName]));

      // Example like btn search
      if (isset($params['eventUpdateItemsList']) && $params['eventUpdateItemsList'])
        $this->updateItemsList();

    }

    \Log::info("FILTERS: " . json_encode($this->filtersValues));

    // remove d-none frontend
    $this->dispatchBrowserEvent('filters-after-get-data');
  }

  /*
  * Action
  * Button Filter
  */
  public function updateItemsList()
  {

    \Log::info("FILTERS - UPDATE ITEMS LIST", [$this->filtersValues]);
    if (!empty($this->filtersValues) && count($this->filtersValues) > 0) {
      $filterToSend = [];
      foreach ($this->filtersValues as $key => $filter) {
        \Log::info("FILTER NAME:{$key} - VALUE:" . json_encode($filter));

        /*
        foreach ($filter as $key => &$filterCheck)
          if(!$filterCheck)
            unset($filter[$key]);
        */

        $filterToSend = array_merge_recursive($filterToSend, $filter);
      }
      \Log::info("FILTER TO SEND TO ITEMSLIST -" . json_encode($filterToSend));

      if (!empty($filterToSend) && count($filterToSend) > 0) {

        if (!empty($this->goToUrl)) {

          $urlParams = "";
          foreach ($filterToSend as $key => $filter) {
            $urlParams .= http_build_query(["filter" => [$key => $filter]]) . "&";
          }
          if ($urlParams)
            redirect()->to($this->goToUrl . "?" . $urlParams);

          return;
        }
        $this->emit('itemsListGetData', [
          'filter' => $filterToSend
        ]);

        if (!empty($this->extraModalId))
          $this->dispatchBrowserEvent('filters-close-modal');

        // remove d-none frontend
        $this->dispatchBrowserEvent('filters-after-get-data');
      }
    }

    // remove d-none frontend
    $this->dispatchBrowserEvent('filters-after-get-data');

  }

  /*
  * Action
  * Button Clear Values
  */
  public function clearValuesFilters()
  {

    if (!empty($this->filtersValues)) {
      $this->filtersValues = [];
      $this->emit('filtersClearValues');
      $this->emit('itemsListClearValues');

    }

    // remove d-none frontend
    $this->dispatchBrowserEvent('filters-after-get-data');

  }

  /*
  * Render
  *
  */
  public function render()
  {

    //$tpl = 'isite::frontend.livewire.filters';
    //return view($tpl);
    return view($this->view);

  }

}