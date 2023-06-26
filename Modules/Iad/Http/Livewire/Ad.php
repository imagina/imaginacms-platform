<?php

namespace Modules\Iad\Http\Livewire;

use Livewire\Component;
use Modules\Iad\Repositories\AdRepository;

class Ad extends Component
{
    public $ad;

    protected $listeners = ['makeComplaint'];

    public function mount()
    {
    }

    public function makeComplaint($adId)
    {
        $adToComplaint = $this->adRepository()->getItem($adId);
        $this->dispatchBrowserEvent('adToComplaintModal', ['adTitle' => $adToComplaint->title]);
    }

//|--------------------------------------------------------------------------
//| Repositories
//|--------------------------------------------------------------------------
    private function adRepository(): adRepository
    {
        return app('Modules\Iad\Repositories\AdRepository');
    }
}
