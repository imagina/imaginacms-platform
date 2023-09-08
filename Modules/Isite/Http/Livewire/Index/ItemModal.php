<?php

namespace Modules\Isite\Http\Livewire\Index;

use Livewire\Component;

class ItemModal extends Component
{
    /**
     * Attributes
     */
    public $mobile;

    public $desktop;

    public $view;

    public $params;

    public $repository;

    public $idModal;

    /**
     * Listeners
     */
    protected $listeners = [
        'itemModalLoadData' => 'getData',
    ];

    /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
    public function mount(
    $mobile = false,
    $desktop = false,
    $view = 'isite::frontend.livewire.index.partials.item-modal-content',
    $params = null,
    $repository = null,
    $idModal = 'itemModal'
    ) {
        $this->mobile = $mobile;
        $this->desktop = $desktop;
        $this->view = $view;
        $this->params = $params;
        $this->repository = $repository;
        $this->idModal = $idModal;
    }

    /*
    * Listener - itemModalLoadData
    *
    */
    public function getData($itemId, $idModalNew)
    {
        //\Log::info("ItemModal - GETDATA : {$itemId} - {$idModalNew}");

        $item = $this->getItemRepository()->getItem($itemId, json_decode(json_encode($this->params)));
    //\Log::info("ItemModal - : ".($item->id ?? 'asdasd')." $this->repository"." ". json_encode($this->params));

    //TODO check why this method (getData) is called twice, in the meantime I'm doing this validation to avoid $item with null value in sometimes
    if(isset($item->id)){
        //'item' => json_decode(json_encode($item), FALSE)
        $newHtml = view($this->view, [
            'item' => $item,
            'inModal' => true,
        ])->render();

        if ($idModalNew == $this->idModal) {
            $this->dispatchBrowserEvent('item-load-modal-content-'.$this->idModal, [
                'newHtml' => $newHtml,
                'itemUrl' => $item->url ?? '',
                'idModalNew' => $idModalNew,
            ]);
        }
    }
    
    
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
    * Render
    *
    */
    public function render()
    {
        $view = 'isite::frontend.livewire.index.item-modal';

        return view($view);
    }
}
