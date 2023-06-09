<?php

namespace Modules\Menu\Presenters;

use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Isite\Entities\Organization;
use Nwidart\Menus\MenuItem;
use Nwidart\Menus\Presenters\Presenter;

class NavbarPresenter extends Presenter
{
    public function setLocale($item)
    {
        // Get organization
        $organization = null;

        if (isset($item->attributes['organization_id']) && ! is_null($item->attributes['organization_id'])) {
            if (isset(tenant()->id)) {
                $organization = tenant();
            }
        }

        if (Str::startsWith($item->url, 'http')) {
            return;
        }
        if (LaravelLocalization::hideDefaultLocaleInURL() === true) {
            if (! is_null($organization)) {
                $item->url = $organization->url.'/'.$item->url;
            } else {
                $item->url = \LaravelLocalization::localizeUrl($item->url);
            }
        }
    }

    /**
     * {@inheritdoc}.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL.'<ul class="nav navbar-nav">'.PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL.'</ul>'.PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithoutDropdownWrapper($item)
    {
        $this->setLocale($item);

        return '<li class="nav-item"'.$this->getActiveState($item).'><a class="nav-link '.($item->attributes['class'] ?? '').'" href="'.$item->getUrl().'" '.$item->getAttributes().'>'.$item->getIcon().''.$item->title.'</a></li>'.PHP_EOL;
    }

    /**
     * {@inheritdoc}.
     */
    public function getActiveState($item, $state = ' class="active"')
    {
        return $item->isActive() ? $state : null;
    }

    /**
     * Get active state on child items.
     */
    public function getActiveStateOnChild($item, string $state = 'active'): ?string
    {
        return $item->hasActiveOnChild() ? $state : null;
    }

    /**
     * {@inheritdoc}.
     */
    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="dropdown-header">'.$item->title.'</li>';
    }

    /**
     * {@inheritdoc}.
     */
    public function getMenuWithDropDownWrapper($item)
    {
        return '<li class="nav-item dropdown'.$this->getActiveStateOnChild($item, ' active').'">
		          <a href="#" class="nav-link dropdown-toggle  '.($item->attributes['class'] ?? '').'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					'.$item->getIcon().' '.$item->title.'
			      
			      </a>
			      <ul class="dropdown-menu">
			      	'.$this->getChildMenuItems($item).'
			      </ul>
		      	</li>'
          .PHP_EOL;
    }

    /**
     * Get multilevel menu wrapper.
     */
    public function getMultiLevelDropdownWrapper(MenuItem $item): string
    {
        return '<li class="nav-item dropdown'.$this->getActiveStateOnChild($item, ' active').'">
		          <a href="#" class="nav-link dropdown-toggle '.($item->attributes['class'] ?? '').'" data-toggle="dropdown">
					'.$item->getIcon().' '.$item->title.'
			      
			      </a>
			      <ul class="dropdown-menu">
			      	'.$this->getChildMenuItems($item).'
			      </ul>
		      	</li>'
          .PHP_EOL;
    }
}
