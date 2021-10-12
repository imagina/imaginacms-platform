<?php

namespace Modules\Menu\Presenters;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Nwidart\Menus\MenuItem;
use Nwidart\Menus\Presenters\Presenter;
use Illuminate\Support\Str;

class NavbarPresenter extends Presenter
{
  
  public function setLocale($item)
  {
    if (Str::startsWith($item->url, 'http')) {
      return;
    }
    if (LaravelLocalization::hideDefaultLocaleInURL() === true) {
      $item->url = \LaravelLocalization::localizeUrl($item->url);
    }
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getOpenTagWrapper()
  {
    return PHP_EOL . '<ul class="nav navbar-nav">' . PHP_EOL;
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getCloseTagWrapper()
  {
    return PHP_EOL . '</ul>' . PHP_EOL;
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getMenuWithoutDropdownWrapper($item)
  {
    $this->setLocale($item);
    return '<li class="nav-item"'. $this->getActiveState($item) . '><a class="nav-link '.($item->attributes['class'] ?? '').'" href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . '' . $item->title . '</a></li>' . PHP_EOL;
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getActiveState($item, $state = ' class="active"')
  {
    return $item->isActive() ? $state : null;
  }
  
  /**
   * Get active state on child items.
   *
   * @param $item
   * @param string $state
   *
   * @return null|string
   */
  public function getActiveStateOnChild($item, $state = 'active')
  {
    return $item->hasActiveOnChild() ? $state : null;
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getDividerWrapper()
  {
    return '<li class="divider"></li>';
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getHeaderWrapper($item)
  {
    return '<li class="dropdown-header">' . $item->title . '</li>';
  }
  
  /**
   * {@inheritdoc }.
   */
  public function getMenuWithDropDownWrapper($item)
  {
    
    return '<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="nav-link dropdown-toggle  '.($item->attributes['class'] ?? '').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					' . $item->getIcon() . ' ' . $item->title . '
			      
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
      . PHP_EOL;
  }
  
  /**
   * Get multilevel menu wrapper.
   *
   * @param \Nwidart\Menus\MenuItem $item
   *
   * @return string`
   */
  public function getMultiLevelDropdownWrapper($item)
  {
    return '<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="nav-link dropdown-toggle '.($item->attributes['class'] ?? '').'" data-toggle="dropdown">
					' . $item->getIcon() . ' ' . $item->title . '
			      
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
      . PHP_EOL;
  }
}
