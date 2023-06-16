<?php

namespace Modules\Iad\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class AdUpForm extends Component
{
    public $upSelected;

    public $fromDate;

    public $toDate;

    public $fromHour;

    public $toHour;

    public $item;

    public $endDateMessage;

    public $hourRangeMessage;

    public $upId;

    public $fullDay;

    public $invalidData;

    public $featuredProduct;

    protected $ups;

    /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
    public function mount(Request $request, $item)
    {
        $this->fromDate = date('Y-m-d');
        $this->toDate = null;
        $this->fromHour = date('H:i');
        $this->item = $item;
        $this->upId = null;
        $this->endDateMessage = '';
        $this->hourRangeMessage = '';
        $this->featuredProduct = null;
        $this->load();
        $this->fullDay = false;
        $this->invalidData = false;
    }

  protected function load()
  {
      $this->initUps();
      $this->initFeaturedProduct();
  }

  public function updated($name, $value)
  {
      if ($value && $this->upId && $this->fromDate) {
          $up = $this->ups->where('id', $this->upId)->first();

          if (isset($up->id)) {
              $this->toDate = \DateTime::createFromFormat('Y-m-d', $this->fromDate);
              $this->toDate->add(new \DateInterval('P'.($up->days_limit - 1).'D'));

              $this->endDateMessage = 'Tu plan de subidas durará hasta el: <strong>'.$this->toDate->format('d/m/Y').'</strong>';
          }
      }

      if ($name == 'fullDay' && $value == 'on') {
          $this->fromHour = '00:00:00';
          $this->toHour = '23:59:59';
      }

      if ($value && $this->fromHour && $this->toHour && $this->upId) {
          $this->hourRangeMessage = '';
          $up = $this->ups->where('id', $this->upId)->first();
          $rangeMinutes = (strtotime($this->toHour) - strtotime($this->fromHour)) / 60;
          $rangeMinutesEveryUp = round($rangeMinutes / $up->ups_daily, 0);

          if ($rangeMinutesEveryUp > 0) {
              $this->hourRangeMessage = "Tu Anuncio subirá cada $rangeMinutesEveryUp minutos";
              $this->invalidData = false;
          } else {
              $this->hourRangeMessage = 'Has seleccionado un rango inválido';
              $this->invalidData = true;
          }
      }
  }

  //|--------------------------------------------------------------------------
  //| Livewire Events
  //|--------------------------------------------------------------------------

  public function hydrate()
  {
      $this->load();
  }

  public function initFeaturedProduct()
  {
      if (is_module_enabled('Icommerce')) {
          $this->featuredProduct = $this->productRepository()->getItem(config('asgard.iad.config.featuredProductId'));
      }
  }

  public function initUps()
  {
      $params = json_decode(json_encode(
          [
              'include' => ['product'],
              'filter' => [
                  'status' => 1,
              ],
          ]
      ));

      $this->ups = $this->upRepository()->getItemsBy($params);
  }

  //|--------------------------------------------------------------------------
  //| Repositories
  //|--------------------------------------------------------------------------
  /**
   * @return paymentMethodRepository
   */
  private function upRepository()
  {
      return app('Modules\Iad\Repositories\UpRepository');
  }

  //|--------------------------------------------------------------------------
  //| Repositories
  //|--------------------------------------------------------------------------
  /**is
   * @return paymentMethodRepository
   */
  private function productRepository()
  {
      if (is_module_enabled('Icommerce')) {
          return app('Modules\Icommerce\Repositories\ProductRepository');
      }
  }

    /*
    * Render
    *
    */
    public function render()
    {
        $tpl = 'iad::frontend.livewire.buy-up';

        return view($tpl, ['ups' => $this->ups]);
    }
}
