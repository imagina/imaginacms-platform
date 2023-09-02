<?php

namespace Modules\Iblog\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Iblog\Repositories\CategoryRepository;

class CategoriesWidget extends BaseWidget
{
    /**
     * @var CategoryRepository
     */
    private $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Get the widget name
     */
    protected function name()
    {
        return 'CategoriesWidget';
    }

    /**
     * Get the widget view
     */
    protected function view()
    {
        return 'iblog::admin.widgets.categories';
    }

    /**
     * Get the widget data to send to the view
     */
    protected function data()
    {
        return ['categoryCount' => $this->category->all()->count()];
    }

    /**
     * Get the widget type
     */
    protected function options()
    {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '2',
        ];
    }
}
