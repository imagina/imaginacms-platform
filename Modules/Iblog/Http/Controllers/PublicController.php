<?php

namespace Modules\Iblog\Http\Controllers;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Ifeeds\Support\SupportFeed;
use Modules\Tag\Repositories\TagRepository;
use Request;
use Route;
use Modules\Page\Http\Controllers\PublicController as PageController;

class PublicController extends BasePublicController
{
    /**
     * @var PostRepository
     */
    private $post;
    private $category;
    private $tag;

    public function __construct(PostRepository $post, CategoryRepository $category, TagRepository $tag)
    {
        parent::__construct();
        $this->post = $post;
        $this->category = $category;
        $this->tag = $tag;
    }

    public function index()
    {
        $slug = Request::path();
        //Default Template
        $tpl = 'iblog::frontend.index';
        $ttpl = 'iblog.index';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        $category = $this->category->findBySlug($slug);
        $posts = $this->post->whereCategory($category->id);
        //Get Custom Template.

        $ptpl = "iblog.category.{$category->parent_id}.index";
        if ($category->parent_id != 0 && view()->exists($ptpl)) {
            $tpl = $ptpl;
        }
        $ctpl = "iblog.category.{$category->id}.index";
        if (view()->exists($ctpl)) $tpl = $ctpl;

        return view($tpl, compact('posts', 'category'));

    }

    public function show($slug)
    {
        $post = $this->post->findBySlug($slug);
        $category = $post->category;
        $tpl = 'iblog::frontend.show';
        $ttpl = 'iblog.show';

        if (view()->exists($ttpl)) $tpl = $ttpl;

        $tags = $post->tags()->get();

        $ptpl = "iblog.category.{$category->parent_id}.show";
        if ($category->parent_id != 0 && view()->exists($ptpl)) {
            $tpl = $ptpl;
        }
        //Get Custom Template.
        $ctpl = "iblog.category.{$category->id}.show";


        if (view()->exists($ctpl)) $tpl = $ctpl;


        return view($tpl, compact('post', 'category', 'tags'));


    }

    public function tag($slug)
    {

        //Default Template
        $tpl = 'iblog::frontend.tag';
        $ttpl = 'iblog.tag';
        $tag = $this->tag->findBySlug($slug);
        if (view()->exists($ttpl)) $tpl = $ttpl;

        $posts = $this->post->whereTag($slug);
        //Get Custom Template.
        $ctpl = "iblog.tag.{$tag->id}";
        if (view()->exists($ctpl)) $tpl = $ctpl;


        return view($tpl, compact('posts', 'tag'));

    }

    public function feed($format)
    {
        $postPerFeed = config('asgard.iblog.config.postPerFeed');
        $posts = $this->post->whereFilters((object)['status' => 'publicado', 'take' => $postPerFeed]);
        $feed = new SupportFeed($format, $posts);
        $feed_logo = config('asgard.iblog.config.logo');
        return $feed->feed($feed_logo);

    }

}
