<?php

namespace Modules\Iprofile\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class UserMenu extends Component
{
  public $view;
  public $user;
  public $params;
  public $showLabel;
  public $moduleLinks;
  public $id;
  public $openLoginInModal;
  public $openRegisterInModal;
  protected $authApiController;

  public function __construct($layout = 'user-menu-layout-1', $showLabel = false, $id = "userMenuComponent",
                              $params = [], $openLoginInModal = true, $openRegisterInModal = false,
                              $onlyShowInTheDropdownHeader = true, $onlyShowInTheMenuOfTheIndexProfilePage = false)
  {

    $this->view = 'iprofile::frontend.components.user-menu.layouts.' . (isset($layout) ? $layout : 'user-menu-layout-1') . '.index';

    $this->showLabel = $showLabel;
    $this->openLoginInModal = $openLoginInModal;
    $this->openRegisterInModal = $openRegisterInModal;

    $this->authApiController = app("Modules\Iprofile\Http\Controllers\Api\AuthApiController");
    $modules = app('modules')->allEnabled();

    $this->moduleLinks = [];
    $locale = LaravelLocalization::setLocale() ?: \App::getLocale();
    foreach ($modules as $name => $module) {
      $moduleLinksCfg = config('asgard.' . strtolower($name) . '.config.userMenuLinks');
      if (!empty($moduleLinksCfg)) {
        foreach ($moduleLinksCfg as &$moduleLink) {
          if (
            ($onlyShowInTheDropdownHeader && !isset($moduleLink["onlyShowInTheMenuOfTheIndexProfilePage"]))
            ||
            ($onlyShowInTheMenuOfTheIndexProfilePage && !isset($moduleLink["onlyShowInTheDropdownHeader"]))
          ) {
            $routeWithLocale = $locale . '.' . $moduleLink['routeName'];
            if (Route::has($routeWithLocale))
              $moduleLink['routeName'] = $routeWithLocale;
            else if (!Route::has($moduleLink['routeName']))
              $moduleLink['routeName'] = 'homepage';
            $this->moduleLinks[] = $moduleLink;

          }

        }
      }
    }

    $this->id = $id ?? "userMenuComponent";
  }

  private function makeParamsFunction()
  {

    return [
      "include" => $this->params["include"] ?? [],
      "take" => $this->params["take"] ?? 12,
      "page" => $this->params["page"] ?? false,
      "filter" => $this->params["filter"] ?? ["locale" => \App::getLocale()],
      "order" => $this->params["order"] ?? null,
    ];
  }

  public function render()
  {
    $this->user = null;

    if (\Auth::user()) {
      $user = $this->authApiController->me();
      $user = json_decode($user->getContent());
      $this->user['data'] = $user->data->userData;
    }

    return view($this->view);
  }
}
