<?php

namespace Modules\Isite\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;
use Modules\Setting\Entities\Setting;

class Captcha extends Component
{

  public $formId;
  public $captchaEnabled;
  public $params;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($formId  = "formsuscripcion", $params = [])
  {
    $this->formId = $formId ?? "formsuscripcion";
    $this->captchaEnabled = setting('isite::activateCaptcha',null, '0');
    $this->params = array_merge($params ?? [], [
        'id' => 'captcha'.$this->formId,
        'data-sitekey' => setting('isite::reCaptchaV2Site') ?? setting('isite::reCaptchaV3Site'),
        'data-callback' => "enable{$formId}Button",
        'data-expired-callback' => "disable{$formId}Button",
        'data-error-callback' => "disable{$formId}Button",
    ]);
  }


  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public function render()
  {
    return view("isite::frontend.components.captcha");
  }
}
