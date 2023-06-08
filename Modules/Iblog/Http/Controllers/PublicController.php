<?php

namespace Modules\Iblog\Http\Controllers;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Iblog\Transformers\CategoryTransformer;
use Modules\Iblog\Entities\Category;
use Modules\Ifeeds\Support\SupportFeed;
use Modules\Tag\Repositories\TagRepository;
use Request;
use Route;
use Modules\Page\Http\Controllers\PublicController as PageController;
use Illuminate\Support\Str;

use Modules\Page\Repositories\PageRepository;

class PublicController extends BasePublicController
{
  /**
   * @var PostRepository
   */
  private $post;
  private $category;
  private $tag;
  private $pageRepository;

  public function __construct(
    PostRepository $post, 
    CategoryRepository $category, 
    TagRepository $tag,
    PageRepository $pageRepository
    ){
    parent::__construct();
    $this->post = $post;
    $this->category = $category;
    $this->tag = $tag;
    $this->pageRepository = $pageRepository;
  }

  public function index($category,$request)
  {

    //Validation with lang from URL
    $result = validateLocaleFromUrl($request,['entity' => $category]);
    if(isset($result["reedirect"]))
      return redirect()->to($result["url"]);
    
    
    //Default Template
    $tpl = 'iblog::frontend.index';
    $ttpl = 'iblog.index';

    if (view()->exists($ttpl)) $tpl = $ttpl;


    $configFilters = config("asgard.iblog.config.filters");

    $posts = $this->post->whereCategory($category->id);
    //Get Custom Template.

    $categoryBreadcrumb = CategoryTransformer::collection(Category::defaultOrder()->ancestorsAndSelf($category->id));

    $layoutCategory = setting('iblog::layoutCategoryBlog');
    if (isset($layoutCategory) && !empty($layoutCategory)) {
      $tpl = $layoutCategory;
      $themeLayoutCategory = str_replace('::frontend.','.',$layoutCategory);
      if (view()->exists($themeLayoutCategory)) {
        $tpl = $themeLayoutCategory;
      }
    }

    $layoutPath = $category->typeable->layout_path ?? null;
    if (isset($layoutPath)) {
      $tpl = $layoutPath;
      $themeLayoutCategory = str_replace('::frontend.','.',$layoutCategory);
      if (view()->exists($themeLayoutCategory)) {
        $tpl = $themeLayoutCategory;
      }
    }

    $ptpl = "iblog.category.{$category->parent_id}.index";
    if ($category->parent_id != 0 && view()->exists($ptpl)) {
      $tpl = $ptpl;
    }
    $ctpl = "iblog.category.{$category->id}.index";
    if (view()->exists($ctpl)) $tpl = $ctpl;

    if (isset($category->options->template) && !empty($category->options->template)) {
      if (view()->exists($category->options->template)) $tpl = $category->options->template;
    }


    $this->addAlternateUrls(alternate($category));

    $configFilters["categories"]["itemSelected"] = $category;

    config(["asgard.iblog.config.filters" => $configFilters]);

    // Get organization
    $organization = null;
    if (isset(tenant()->id)) {
      $organization = tenant();
    }

    return view($tpl, compact('posts', 'category', 'categoryBreadcrumb','organization'));

  }

  public function show($post,$request)
  {

    $category = $post->category;

    //Validation with lang from URL
    $result = validateLocaleFromUrl($request,['entity' => $post]);
    if(isset($result["reedirect"]))
      return redirect()->to($result["url"]);
    
   

    $tpl = 'iblog::frontend.show';
    $ttpl = 'iblog.show';

    if (view()->exists($ttpl)) $tpl = $ttpl;

    $tags = $post->tags()->get();

    $layoutCategory = setting('iblog::layoutPostBlog');
    if (isset($layoutCategory) && !empty($layoutCategory)) {
      $tpl = $layoutCategory;
      $themeLayoutCategory = str_replace('::frontend.','.',$layoutCategory);
      if (view()->exists($themeLayoutCategory)) {
        $tpl = $themeLayoutCategory;
      }
    }

    $layoutPath = $post->typeable->layout_path ?? null;
    if (isset($layoutPath)) {
      $tpl = $layoutPath;
      $themeLayoutCategory = str_replace('::frontend.','.',$layoutCategory);
      if (view()->exists($themeLayoutCategory)) {
        $tpl = $themeLayoutCategory;
      }
    }

    $ptpl = "iblog.category.{$category->parent_id}.show";
    if ($category->parent_id != 0 && view()->exists($ptpl)) {
      $tpl = $ptpl;
    }
    //Get Custom Template.
    $ctpl = "iblog.category.{$category->id}.show";

    $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
    if (view()->exists($ctpl)) $tpl = $ctpl;

    $this->addAlternateUrls(alternate($post));
    
    //meta keywords
    $metaKeywords = (implode("," ,$post->meta_keywords ?? [])).
      join(",", $post->tags->pluck('name')->toArray());

    // Get organization
    $organization = null;
    if (isset(tenant()->id)) {
      $organization = tenant();
    }

    return view($tpl, compact('post', 'category', 'tags', 'categoryBreadcrumb','metaKeywords','organization'));


  }

  public function tag($slug)
  {

    //Default Template
    $tpl = 'iblog::frontend.index';
    $ttpl = 'iblog.index';
    $tag = $this->tag->findBySlug($slug);

    if (!isset($tag->id)) return response()->view('errors.404', [], 404);
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
