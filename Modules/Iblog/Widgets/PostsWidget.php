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
     *
     * @return string
     */
    protected function name(): string
    {
        return 'PostsWidget';
    }

    /**
     * Get the widget view
     *
     * @return string
     */
    protected function view(): string
    {
        return 'iblog::admin.widgets.posts';
    }

    /**
     * Get the widget data to send to the view
     *
     * @return string
     */
    protected function data(): string
    {
        return ['postCount' => $this->post->all()->count()];
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
            'x' => '0',
        ];
    }
}
