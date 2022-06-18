<?php

namespace Modules\Isite\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iprofile\Repositories\UserApiRepository;
use Route;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Str;

class PublicController extends BaseApiController
{
  protected $auth;
  
  public function __construct()
  {
    parent::__construct();
  }
  
  public function homepage(Request $request)
  {

    $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
    
    $organization = tenant();

    if(isset($organization->id)){
      //default view in the Theme
      if (view()->exists("isite.organization.default"))
        return view("isite.organization.default", compact('organization'));
  
      $routeAlias = setting("isite::tenantRouteAlias", null, null, true);
  
      if (isset($organization->id) && $routeAlias) {
        if ($organization->status) {
          return redirect(tenant_route($request->getHost(), $locale . '.' . $routeAlias));
        }
      }
    }
    
  
    //ultimo, busca el slug en Page
    $pageRepository = app("Modules\Page\Repositories\PageRepository");
    $page = $pageRepository->findBySlug("home");
  
    if(isset($page->id)){
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
    $repository = app("Modules\\Iforms\\Repositories\\LeadRepository");
    //Set fields and extra params
    $params = [
      "include" => [],
      "take" => 12,
      "filter" => [
        "id" => 61
      ]
    ];
    //Get query
    $items = $repository->getItemsBy(json_decode(json_encode($params)));
    
    $pdf = \PDF::loadView('isite::pdf.layouts.default', ["data" => [
      "items" => $items,
      "content" => "iforms::pdf.leadItem",
    ]]);
    return $pdf->stream('invoice.pdf');
    return view('isite::pdf.layouts.default', ["data" => [
      "items" => $items,
      "content" => "iforms::pdf.leadItem",
    ]]);
  }
  
  /**
   * @param $slug
   * @return \Illuminate\View\View
   */
  public function uri($slug)
  {

    //Pimero buscamos el path completo en el slug del post, si existe redirige
    $postRepository = app("Modules\Iblog\Repositories\PostRepository");
    $post = $postRepository->getItem($slug,json_decode(json_encode(["filter" => ["field" => "slug"]])));
  
    //el post debe tener un campo falso urlCoder con valor onlyPost que habilite al posts para accederse unicamente con su slug como url
    if(isset($post->id) && isset($post->options->urlCoder) && $post->options->urlCoder=="onlyPost"){
      $controller = app("Modules\Iblog\Http\Controllers\PublicController");
      return $controller->show($post);
    }
  
    //Segundo, busamos el path completo en el slug de la categoria
    $categoryRepository = app("Modules\Iblog\Repositories\CategoryRepository");
    $category = $categoryRepository->getItem($slug,json_decode(json_encode(["filter" => ["field" => "slug"]])));
    
    if(isset($category->id)){
      $controller = app("Modules\Iblog\Http\Controllers\PublicController");
      return $controller->index($category);
    }
 
    //Tercero, buscamos el path menos el ultimo en una categoria, si existe, buscamos el ultimo path en un post con la categoria, redirigimos
    $arg = explode("/",$slug);
    $category = $categoryRepository->getItem(Str::remove("/".end($arg), $slug),json_decode(json_encode(["filter" => ["field" => "slug"]])));
  
    if(isset($category->id)){
      $post = $postRepository->getItem(end($arg),json_decode(json_encode(["filter" => ["categories"=> $category->id,"field" => "slug"]])));
  
      if(isset($post->id)){
        $controller = app("Modules\Iblog\Http\Controllers\PublicController");
        return $controller->show($post);
      }
    }
  
    //ultimo, busca el slug en Page
    $pageRepository = app("Modules\Page\Repositories\PageRepository");
    $page = $pageRepository->findBySlug($slug);

    if(isset($page->id)){
      $controller = app("Modules\Page\Http\Controllers\PublicController");
      return $controller->uri($page,$slug);
    }

    return response()->view('errors.404', [], 404);
  }
  
}
