<?php

namespace Modules\Isite\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Iblog\Entities\Post;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Isite\Repositories\CategoryRepository;

class PublicController extends BaseApiController
{
    protected $auth;

    public $category;

    public function __construct(
    CategoryRepository $category
  ) {
        parent::__construct();
        $this->category = $category;
    }

    public function homepage(Request $request)
    {
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

        $organization = tenant();

        if (isset($organization->id)) {
            //default view in the Theme
            if (view()->exists('isite.organization.default')) {
                return view('isite.organization.default', compact('organization'));
            }

            $routeAlias = setting('isite::tenantRouteAlias', null, null, true);

            if (isset($organization->id) && $routeAlias) {
                if ($organization->status) {
                    return redirect(tenant_route($request->getHost(), $locale.'.'.$routeAlias));
                }
            }
        }

        //ultimo, busca el slug en Page
        $pageRepository = app("Modules\Page\Repositories\PageRepository");
        $page = $pageRepository->findBySlug('home');

        if (isset($page->id)) {
            $controller = app("Modules\Page\Http\Controllers\PublicController");

            return $controller->home($page);
        }
    }

    public function header()
    {
        return view('isite::frontend.header');
    }

    public function footer()
    {
        return view('isite::frontend.footer');
    }

    public function pdf()
    {
        \Artisan::call('view:clear');
        $repository = app('Modules\\Iforms\\Repositories\\LeadRepository');
        //Set fields and extra params
        $params = [
            'include' => [],
            'take' => 12,
            'filter' => [
                'id' => 61,
            ],
        ];
        //Get query
        $items = $repository->getItemsBy(json_decode(json_encode($params)));

        $pdf = \PDF::loadView('isite::pdf.layouts.default', ['data' => [
            'items' => $items,
            'content' => 'iforms::pdf.leadItem',
        ]]);

        return $pdf->stream('invoice.pdf');

        return view('isite::pdf.layouts.default', ['data' => [
            'items' => $items,
            'content' => 'iforms::pdf.leadItem',
        ]]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function uri($slug, Request $request): View
    {
        try {
            //revoke api routes
            if (Str::contains($slug, 'api')) {
                return response('', 404);
            }

            //Pimero buscamos el path completo en el slug del post, si existe redirige
            $postRepository = app("Modules\Iblog\Repositories\PostRepository");
            $post = $postRepository->getItem($slug, json_decode(json_encode(['filter' => ['field' => 'slug']])));

            //el post debe tener un campo falso urlCoder con valor onlyPost que habilite al posts para accederse unicamente con su slug como url
            if (isset($post->id) && isset($post->options->urlCoder) && $post->options->urlCoder == 'onlyPost') {
                $controller = app("Modules\Iblog\Http\Controllers\PublicController");

                return $controller->show($post, $request);
            }

            //Segundo, busamos el path completo en el slug de la categoria
            $categoryRepository = app("Modules\Iblog\Repositories\CategoryRepository");
            $category = $categoryRepository->getItem($slug, json_decode(json_encode(['filter' => ['field' => 'slug']])));

            if (isset($category->id)) {
                $controller = app("Modules\Iblog\Http\Controllers\PublicController");

                return $controller->index($category, $request);
            }

            //Tercero, buscamos el path menos el ultimo en una categoria, si existe, buscamos el ultimo path en un post con la categoria, redirigimos
            $arg = explode('/', $slug);
            $category = $categoryRepository->getItem(Str::remove('/'.end($arg), $slug), json_decode(json_encode(['filter' => ['field' => 'slug']])));

            if (isset($category->id)) {
                $post = $postRepository->getItem(end($arg), json_decode(json_encode(['filter' => ['categories' => $category->id, 'field' => 'slug']])));

                if (isset($post->id)) {
                    $controller = app("Modules\Iblog\Http\Controllers\PublicController");

                    return $controller->show($post, $request);
                }
            }
        } catch(\Exception $e) {
            \Log::info($e->getMessage());
        }

        //ultimo, busca el slug en Page
        $pageRepository = app("Modules\Page\Repositories\PageRepository");
        $page = $pageRepository->findBySlug($slug);

        if (isset($page->id)) {
            $controller = app("Modules\Page\Http\Controllers\PublicController");

            return $controller->uri($page, $slug, $request);
        }

        return response()->view('errors.404', [], 404);
    }

    /*
    * Organization Index
    */
    public function index(Request $request)
    {
        $argv = explode('/', $request->path());
        $slug = end($argv);

        $tpl = 'isite::frontend.organizations.index';
        $ttpl = 'isite.organizations.index';

        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        $category = null;

        if ($slug && $slug != trans('isite::routes.organizations.index.index')) {
            $category = $this->category->findBySlug($slug);

            if (isset($category->id)) {
                $ptpl = "isite.category.{$category->parent_id}%.index";
                if ($category->parent_id != 0 && view()->exists($ptpl)) {
                    $tpl = $ptpl;
                }

                $ctpl = "isite.category.{$category->id}.index";
                if (view()->exists($ctpl)) {
                    $tpl = $ctpl;
                }

                $ctpl = "isite.category.{$category->id}%.index";
                if (view()->exists($ctpl)) {
                    $tpl = $ctpl;
                }
            } else {
                return response()->view('errors.404', [], 404);
            }
        }

        $title = (isset($category->id) ? ($category->h1_title ?? $category->title) : trans('isite::organizations.plural'));

        return view($tpl, compact('title', 'category'));
    }
}
