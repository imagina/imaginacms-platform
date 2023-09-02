<?php

namespace Modules\Dashboard\Composers;

use Illuminate\Contracts\View\View;

class WidgetViewComposer
{
    /**
     * @var array
     */
    private $subViews = [];

    public function compose(View $view)
    {
        $view->with(['widgets' => $this->subViews]);
    }

    /**
     * Add the html of the widget view to the given widget name
     */
    public function addSubview($name, $view)
    {
        $this->subViews[$name]['html'] = $view;

        return $this;
    }

    /**
     * Add widget options to the given widget name
     */
    public function addWidgetOptions($name, array $options)
    {
        $this->subViews[$name]['options'] = $options;

        return $this;
    }

    /**
     * Set the widget name
     */
    public function setWidgetName($name)
    {
        $this->subViews[$name]['id'] = $name;

        return $this;
    }
}
