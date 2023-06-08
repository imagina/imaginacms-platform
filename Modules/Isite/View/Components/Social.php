<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;

class Social extends Component
{
  
  
  public $items;
  public $view;
  public $itemLayout;
  public $components;
  public $layout;
  public $type;
  public $customIcons;
  public $id;
  public $position;
  public $size;
  public $whatsappAttributes;
  public $central;
  public $withWhatsapp;
  public $iconSize;
  public $iconBackgroundSize;
  public $iconColor1;
  public $iconColor2;
  public $iconBorderRadius;
  public $iconBorderRadiusType;
  public $iconRadius;
  public $iconRadiusHover;
  public $iconBorderWidth;
  public $iconDisplay;
  public $iconStyle;
  public $iconBoxShadow;
  public $iconTextShadow;
  public $iconMargin;
  public $iconAnimate;
  public $idSocial;
  
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($layout = 'social-layout-1',
                              $type = '',
                              $customIcons = [],
                              $id = 'socialComponent',
                              $whatsappAttributes = [],
                              $size = 'lg',
                              $central = false,
                              $withWhatsapp = true,
                              $iconSize= '16px',
                              $iconBackgroundSize= '40px',
                              $iconColor1= 'var(--primary)',
                              $iconColor2= '',
                              $iconBorderRadius= '0',
                              $iconBorderWidth= '0',
                              $iconDisplay= 'flex',
                              $iconStyle= '',
                              $iconBorderRadiusType='1',
                              $iconBoxShadow = '',
                              $iconTextShadow = '',
                              $iconMargin = '0 0 5px  0',
                              $iconAnimate='',
                              $idSocial = ''
  )
  {
    /*$this->id = $id ?? 'socialComponent';*/
    $this->type = $type ?? '';
    $this->view = "isite::frontend.components.social.layouts.{$layout}.index";
    $this->customIcons = $customIcons;
    $this->idSocial = $idSocial;
    if($this->idSocial!=''){
        $this->id = $this->idSocial;
    } else {
        $this->id = $id;
    }
    $this->position = $position ?? 'static';
    $this->size = $size ?? 'lg';
    $this->central = $central ?? null;
    $this->withWhatsapp = $withWhatsapp;
    $this->iconSize = explode(",",$iconSize);
    $this->iconBackgroundSize = explode(",",$iconBackgroundSize);
    $this->iconColor1 = $iconColor1;
    $this->iconColor2 = $iconColor2;
    $this->iconBorderRadius = explode(",",$iconBorderRadius);
    $this->iconBorderRadiusType = $iconBorderRadiusType;
    $this->iconBorderWidth = $iconBorderWidth;
    $this->iconDisplay = $iconDisplay;
    $this->iconStyle = $iconStyle;
    $this->iconBoxShadow = explode(",",$iconBoxShadow);
    $this->iconTextShadow = explode(",",$iconTextShadow);
    $this->iconMargin = $iconMargin;
    $this->iconAnimate = $iconAnimate;
    $this->iconRadius = $this->radiusType($this->iconBorderRadius[0]);
    if(count($this->iconBorderRadius)==2) {
        $this->iconRadiusHover = $this->radiusType($this->iconBorderRadius[1]);
    }

    //validate whatsapp attributes
    $this->whatsappAttributes = is_array($whatsappAttributes) && count($whatsappAttributes) > 0 ? $whatsappAttributes : ['size' => $this->size, 'type' => $this->type];

  }
  
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function radiusType($radius){
    //{{-- 1 all, 2 top, 3 right, 4 left, 5 bottom, 6 top right, 7 top left, 8 bottom right, 9 top left --}}
    switch ($this->iconBorderRadiusType) {
      case '2':
          $radiusAll = $radius . "px " . $radius . "px 0 0";
          break;
      case '3':
          $radiusAll = "0 " . $radius . "px " . $radius . "px 0";
          break;
      case '4':
          $radiusAll = $radius . "px 0 0 " . $radius . "px";
          break;
      case '5':
          $radiusAll = "0 0 " . $radius . "px " . $radius . "px";
          break;
      case '6':
          $radiusAll = $radius . "px 0 " . $radius . "px " . $radius . "px";
          break;
      case '7':
          $radiusAll = "0 " . $radius . "px " . $radius . "px " . $radius . "px";
          break;
      case '8':
          $radiusAll = $radius . "px " . $radius . "px 0 " . $radius . "px";
          break;
      case '9':
          $radiusAll = $radius . "px " . $radius . "px " . $radius . "px 0";
          break;
      default:
          $radiusAll = $radius . "px";
          break;
      }
      return $radiusAll;
  }
  public function render()
  {
    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    
    $items = json_decode(setting('isite::socialNetworks',$locale, null, $this->central), true);
    
    $this->items = [];

    $settingRepository = app('Modules\Setting\Repositories\SettingRepository');
    $settingSocial = $settingRepository->findByName('isite::socialNetworks');

    $createdAtSetting = (isset($settingSocial) && !empty($settingSocial)) ? $settingSocial->getAttributes()['created_at'] : now();
    
    foreach ($items as $key => $value) {
      if ($createdAtSetting > '2022-08-29 00:00:00') {
        $this->items[isset($this->customIcons[$key]) ? $this->customIcons[$key] : 'fab fa-' . $key] = $value;
      } else {
        $this->items[isset($this->customIcons[$key]) ? $this->customIcons[$key] : 'fa fa-' . $key] = $value;
      }
    }
    
    return view($this->view);
  }
}
