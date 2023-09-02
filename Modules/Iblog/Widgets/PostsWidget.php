<?php

namespace Modules\Iblog\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Iblog\Repositories\PostRepository;

class PostsWidget extends BaseWidget
{
    /**
     * @var \Modules\Iblog\Repositories\PostRepository
     */
    private $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * Get the widget name
     */
    protected function name()
    {
        return 'PostsWidget';
    }

    /**
     * Get the widget view
     */
    protected function view()
    {
        return 'iblog::admin.widgets.posts';
    }

    /**
     * Get the widget data to send to the view
     */
    protected function data()
    {
        return ['postCount' => $this->post->all()->count()];
    }

    /**
     * Get the widget type
     */
    protected function options()
    {
        return [
            'width' => '2',
            'height' => '2',
            'x' => '0',
        ];
    }
}
