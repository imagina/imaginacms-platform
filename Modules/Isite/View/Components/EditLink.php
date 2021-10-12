<?php

namespace Modules\Isite\View\Components;

use Illuminate\View\Component;
use Modules\Media\Entities\File;
use Modules\Setting\Entities\Setting;

class EditLink extends Component
{
  public $top;
  public $bottom;
  public $right;
  public $left;
  public $user;
  public $link;
  public $canAccess;
  public $tooltip;
  public $classes;
  public $idButton;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($link, $tooltip = null, $classes = null, $top = null,
                              $bottom = null, $right = null, $left= null, $idButton = null)
  {
    $this->top = $top ?? '15%';
    $this->bottom = $bottom ?? 'unset';
    $this->right = $right ?? 'unset';
    $this->left = $left ?? '15%';
    $this->link = $link ?? \URL::link('/');
    $this->canAccess = false;
    $this->tooltip = $tooltip ?? trans("isite::common.editLink.tooltip");
    $user = \Auth::user();

    if(isset($user->id)){
      $permissionController = app("Modules\Ihelpers\Http\Controllers\Api\PermissionsApiController");
      $permissions = $permissionController->getAll(["userId" => $user->id]);

      if(isset($permissions['isite.edit-link.manage']) && $permissions['isite.edit-link.manage']){
        $this->canAccess = true ;
      }
    }


  }
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|string
   */
  public
  function render()
  {
    return view("isite::frontend.components.edit-link");
  }
}


