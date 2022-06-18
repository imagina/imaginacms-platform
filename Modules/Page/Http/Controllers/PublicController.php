<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;

class PublicController extends BasePublicController
{
  /**
   * @var PageRepository
   */
  private $page;
  /**
   * @var Application
   */
  private $app;
  
  private $disabledPage = false;
  
  public function __construct(PageRepository $page, Application $app)
  {
    parent::__construct();
    $this->page = $page;
    $this->app = $app;
  }
  
  /**
   * DEPRECATED
   * @param $slug
   * @return \Illuminate\View\View
   */
  public function uri($page,$slug = "")
  {

    $this->throw404IfNotFound($page);

    $currentTranslatedPage = $page->getTranslation(locale());
    
    if(!isset($currentTranslatedPage->slug) || ($page->id == 1 && !empty($slug))){
      return redirect()->to(\LaravelLocalization::localizeUrl('/'), 301);
    }
    
    if ( !empty($slug) && $slug !== $currentTranslatedPage->slug) {
      return redirect()->to(\LaravelLocalization::localizeUrl("/$currentTranslatedPage->slug") , 301);
    }
    
    $template = $this->getTemplateForPage($page);

    $this->addAlternateUrls(alternate($page));
    
    $pageContent = $this->getContentForPage($page);
    return view($template, compact('page', 'pageContent'));
  }
  
  /**
   * @return \Illuminate\View\View
   */
  public function homepage()
  {
   
    $page = $this->page->findHomepage();

    if(isset(tenant()->id)) {
     if(request()->url() != tenant()->url)
      return redirect(tenant()->url);
    }

    $this->throw404IfNotFound($page);
    
    $template = $this->getTemplateForPage($page);
    
    $this->addAlternateUrls(alternate($page));
    
    $pageContent = $this->getContentForPage($page);
    
 
    
    return view($template, compact('page', 'pageContent'));
  }
  
  /**
   * Find a page for the given slug.
   * The slug can be a 'composed' slug via the Menu
   * @param string $slug
   * @return Page
   */
  private function findPageForSlug($slug)
  {
    $menuItem = app(MenuItemRepository::class)->findByUriInLanguage($slug, locale());
    
    if ($menuItem && $menuItem->page_id) {
      return $this->page->find($menuItem->page_id);
    }
    
    return $this->page->findBySlug($slug);
  }
  
  /**
   * Return the template for the given page
   * or the default template if none found
   * @param $page
   * @return string
   */
  private function getTemplateForPage($page)
  {
    return (!empty($page->template) && view()->exists($page->template)) ? $page->template :
      (view()->exists('default') ? 'default' :
        (view()->exists('page.templates.default') ? 'page.templates.default' :
          'page::frontend.page.templates.default'));
  }
  
  /**
   * Throw a 404 error page if the given page is not found or draft
   * @param $page
   */
  private function throw404IfNotFound($page)
  {
    if (null === $page || $page->status === $this->disabledPage) {
      $this->app->abort('404');
    }
  }
  
  /**
   * Create a key=>value array for alternate links
   *
   * @param $page
   *
   * @return array
   */
  private function getAlternateMetaData($page)
  {
    $supportedLocales = config("laravellocalization.supportedLocales");
    
    if(count($supportedLocales) == 1) return [];
    
    $translations = $page->getTranslationsArray();
    
    $alternate = [];
    
    foreach ($translations as $locale => $data) {
      $alternate[$locale] = $data['slug'];
    }
    
    return $alternate;
  }
  
  /**
   * Get the page content validation
   *
   * @param $page
   * @return string
   */
  private function getContentForPage($page)
  {
    $tpl = "page::frontend.page.content.default";
    $ttpl = "pages.content.default";
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $layoutPath = $page->typeable->layout_path ?? null;
  
    //validate if exist the layout from the typeable relation
    if (view()->exists($layoutPath)) $tpl = $layoutPath;
    //revalidate if exist the layout adding the page system name to the end of the path
    elseif (view()->exists($layoutPath.".$page->system_name")) $tpl = $layoutPath.".$page->system_name";
    
    $ttpl = "pages.content.$page->id";
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    $currentLocale = \LaravelLocalization::getCurrentLocale();
    
      if (view()->exists('pages.content.' . $currentLocale . '.' . $page->id)){
        $tpl = "pages.content.$currentLocale.$page->id";
      }

    
    return $tpl;
    
  }
}
