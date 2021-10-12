<?php

namespace Modules\Menu\Presenters;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Nwidart\Menus\MenuItem;
use Nwidart\Menus\Presenters\Presenter;

class NavbarRightPresenter extends Presenter
{
  /**
   * {@inheritdoc }.
   */
  public function getOpenTagWrapper()
  {
    return PHP_EOL . '<ul class="nav navbar-nav navbar-right">' . PHP_EOL;
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getMenuWithDropDownWrapper($item)
  {
    return '<li class="nav-item dropdown">
			      <a href="#" class="nav-link dropdown-toggle'.($item->attributes['class'] ?? '').'"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					' . $item->getIcon() . ' ' . $item->title . '
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
      . PHP_EOL;
  }
}
