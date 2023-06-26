<?php

namespace Modules\Iblog\Widgets;

use Modules\Dashboard\Foundation\Widgets\BaseWidget;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Setting\Contracts\Setting;

class LatestPostsWidget extends BaseWidget
{
    /**
     * @var PostRepository
     */
    private $post;

    public function __construct(PostRepository $post, Setting $setting)
    {
        $this->post = $post;
        $this->setting = $setting;
    }

    /**
     * Get the widget name
     */
    protected function name(): string
    {
        return 'LatestPostsWidget';
    }

    /**
     * Get the widget options
     * Possible options:
     *  x, y, width, height
     */
    protected function options(): string
    {
        return [
            'width' => '4',
            'height' => '4',
        ];
    }

    /**
     * Get the widget view
     */
    protected function view(): string
    {
        return 'iblog::admin.widgets.latest-posts';
    }

    /**
     * Get the widget data to send to the view
     */
    protected function data(): string
    {
        $limit = $this->setting->get('iblog::widget-posts-amount', locale(), 5);

        return ['posts' => $this->post->latest($limit)];
    }
}
