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
     *
     * @return string
     */
    protected function name(): string
    {
        return 'CategoriesWidget';
    }

    /**
     * Get the widget view
     *
     * @return string
     */
    protected function view(): string
    {
        return 'iblog::admin.widgets.categories';
    }

    /**
     * Get the widget data to send to the view
     *
     * @return string
     */
    protected function data(): string
    {
        return ['categoryCount' => $this->category->all()->count()];
    }

    /**
     * Get the widget type
     *
     * @return string
     */
    protected function options(): string
    {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '2',
        ];
    }
}
