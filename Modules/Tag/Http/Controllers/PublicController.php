<?php

namespace Modules\Tag\Http\Controllers;

use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Page\Repositories\PageRepository;
use Modules\Tag\Repositories\TagRepository;

class PublicController extends BaseApiController
{
    private $post;

    private $category;

    private $tag;

    private $page;

    public function __construct(PostRepository $post, CategoryRepository $category, TagRepository $tag, PageRepository $page)
    {
        parent::__construct();
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
        $this->page = $page;
    }

    public function tag($slug)
    {
        //Default Template
        $tpl = 'tag::frontend.tags.index';
        $tag = $this->tag->findBySlug($slug);

        if (! isset($tag->id)) {
            return response()->view('errors.404', [], 404);
        }

        return view($tpl, compact('tag'));
    }
}
