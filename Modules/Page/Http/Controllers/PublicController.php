<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Transformers\PageApiTransformer;

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
     */
    public function uri($page, $slug, Request $request)
    {
        $this->throw404IfNotFound($page);

        //Validation with lang from URL
        $result = validateLocaleFromUrl($request, ['entity' => $page]);
        if (isset($result['reedirect'])) {
            return redirect()->to($result['url']);
        }

        $currentTranslatedPage = $page->getTranslation(locale());

        if (! isset($currentTranslatedPage->slug) || ($page->id == 1 && ! empty($slug))) {
            return redirect()->to(\LaravelLocalization::localizeUrl('/'), 301);
        }

        if (! empty($slug) && $slug !== $currentTranslatedPage->slug) {
            return redirect()->to(\LaravelLocalization::localizeUrl("/$currentTranslatedPage->slug"), 301);
        }

        $template = $this->getTemplateForPage($page);

        $this->addAlternateUrls(alternate($page));

        $pageContent = $this->getContentForPage($page);

        // Return organization
        $organization = tenant() ?? null;

        // transform the page data
        $transformedPage = json_decode(json_encode(new PageApiTransformer($page)));

        return view($template, compact('page', 'pageContent', 'organization', 'transformedPage'));
    }

    public function homepage(Request $request): View
    {
        //Validation with lang from URL
        $result = validateLocaleFromUrl($request);
        if (isset($result['reedirect'])) {
            return redirect()->to($result['url']);
        }

        $page = $this->page->findHomepage();

        if (isset(tenant()->id)) {
            if (request()->url() != tenant()->url) {
                return redirect(tenant()->url);
            }
        }

        $this->throw404IfNotFound($page);

        $template = $this->getTemplateForPage($page);

        $this->addAlternateUrls(alternate($page));

        $pageContent = $this->getContentForPage($page);

        // Return organization
        $organization = tenant() ?? null;

        return view($template, compact('page', 'pageContent', 'organization'));
    }

    /**
     * Find a page for the given slug.
     * The slug can be a 'composed' slug via the Menu
     */
    private function findPageForSlug(string $slug): Page
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
     */
    private function getTemplateForPage($page): string
    {
        return (! empty($page->template) && view()->exists($page->template)) ? $page->template :
          (view()->exists('default') ? 'default' :
            (view()->exists('page.templates.default') ? 'page.templates.default' :
              'page::frontend.page.templates.default'));
    }

    /**
     * Throw a 404 error page if the given page is not found or draft
     */
    private function throw404IfNotFound($page)
    {
        if (null === $page || $page->status === $this->disabledPage || $page->type == 'internal') {
            $this->app->abort('404');
        }
    }

    /**
     * Create a key=>value array for alternate links
     */
    private function getAlternateMetaData($page): array
    {
        $supportedLocales = config('laravellocalization.supportedLocales');

        if (count($supportedLocales) == 1) {
            return [];
        }

        $translations = $page->getTranslationsArray();

        $alternate = [];

        foreach ($translations as $locale => $data) {
            $alternate[$locale] = $data['slug'];
        }

        return $alternate;
    }

    /**
     * Get the page content validation
     */
    private function getContentForPage($page): string
    {
        $tpl = 'page::frontend.page.content.default';
        $ttpl = 'pages.content.default';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        $layoutPath = null;

        $layoutPath = $page->typeable->layout_path ?? null;

        //validate if exist the layout from the typeable relation
        if (view()->exists($layoutPath)) {
            $tpl = $layoutPath;
        }

        //if isset tenant initialized have full priority
        elseif (isset(tenant()->id)) {
            $organization = tenant();

            $layoutPath = $organization->layout->path;

            //validate if exist the layout from the typeable relation
            if (view()->exists($layoutPath)) {
                $tpl = $layoutPath;
            }

            //revalidate if exist the layout adding the page system name to the end of the path
            elseif (view()->exists($layoutPath.".$page->system_name")) {
                $tpl = $layoutPath.".$page->system_name";
            }

            //verify if
            elseif (view()->exists($layoutPath.".$page->id")) {
                $tpl = $layoutPath.".$page->id";
            } else {
                $currentLocale = \LaravelLocalization::getCurrentLocale();
                if (view()->exists($layoutPath.".$currentLocale.".".$page->id")) {
                    $tpl = $layoutPath.".$currentLocale.".".$page->id";
                }
            }
        } else {
            $ttpl = "pages.content.$page->id";
            if (view()->exists($ttpl)) {
                $tpl = $ttpl;
            }

            $currentLocale = \LaravelLocalization::getCurrentLocale();

            if (view()->exists('pages.content.'.$currentLocale.'.'.$page->id)) {
                $tpl = "pages.content.$currentLocale.$page->id";
            }
        }

        return $tpl;
    }
}
