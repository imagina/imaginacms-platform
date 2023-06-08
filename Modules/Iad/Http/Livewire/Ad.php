<?php

namespace Modules\Iad\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Iad\Repositories\AdRepository;
use Illuminate\Support\Facades\Auth;

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
    $this->dispatchBrowserEvent('adToComplaintModal', ["adTitle" => $adToComplaint->title]);
  }

//|--------------------------------------------------------------------------
//| Repositories
//|--------------------------------------------------------------------------
  /**
   * @return adRepository
   */
  private function adRepository()
  {
    return app('Modules\Iad\Repositories\AdRepository');
  }
}