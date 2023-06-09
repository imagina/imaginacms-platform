<?php

namespace Modules\Iad\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Iad\Entities\Category;
use Modules\Iad\Repositories\AdRepository;
use Modules\Iad\Repositories\CategoryRepository;
//Entities
use Modules\Iad\Transformers\CategoryTransformer;
//Entities
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
//Transformers
use mysql_xdevapi\Collection;

class PublicController extends BaseApiController
{
    private $ad;

    private $up;

    private $category;

    private $categoryRepository;

    public function __construct(
    AdRepository $ad,

    CategoryRepository $categoryRepository,
    Category $category
  ) {
        parent::__construct();

        $this->category = $category;
        $this->categoryRepository = $categoryRepository;
        $this->ad = $ad;
        $this->up = app("Modules\Iad\Repositories\UpRepository");
    }

    public function createAd()
    {
        //Get categories
        $categories = $this->category->with('translations')->get();

        //Validate view
        $tpl = 'iad::frontend.adForm.create.view';
        $ttpl = 'iad.adForm.create.view';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        //Render
        return view($tpl, ['categories' => $categories->toTree()]);
    }

    // view products by category
    public function index(Request $request)
    {
        $argv = explode('/', $request->path());
        $slug = end($argv);

        $tpl = 'iad::frontend.index';
        $ttpl = 'iad.index';

        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        $category = null;

        $categoryBreadcrumb = [];

        $configFilters = config('asgard.iad.config.filters');

        if ($slug && $slug != trans('iad::routes.ad.index.index')) {
            $params = ['filter' => ['field' => 'slug']];
            $category = $this->categoryRepository->getItem($slug, json_decode(json_encode($params)));

            if (isset($category->id)) {
                //With nestedset package
                // $categoryBreadcrumb = CategoryTransformer::collection(Category::ancestorsAndSelf($category->id));
                //Without nestedset package
                $categoryBreadcrumb = $this->getCategoryBreadcrumb($category);

                //Without nestedset package
                $ptpl = "Iad.category.{$category->parent_id}%.index";
                if ($category->parent_id != 0 && view()->exists($ptpl)) {
                    $tpl = $ptpl;
                }

                $ctpl = "Iad.category.{$category->id}.index";
                if (view()->exists($ctpl)) {
                    $tpl = $ctpl;
                }

                $ctpl = "Iad.category.{$category->id}%.index";
                if (view()->exists($ctpl)) {
                    $tpl = $ctpl;
                }

                $configFilters['categories']['itemSelected'] = $category;
            } else {
                return response()->view('errors.404', [], 404);
            }
        }

        config(['asgard.iad.config.filters' => $configFilters]);
        //$dataRequest = $request->all();

        return view($tpl, compact('category', 'categoryBreadcrumb'));
    }

    /**
     * Show product
     *
     * @return mixed
     */
    public function show(Request $request)
    {
        $argv = explode('/', $request->path());
        $slug = end($argv);

        $tpl = 'iad::frontend.show';
        $ttpl = 'iad.show';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }
        $params = json_decode(json_encode(
            [
                'include' => explode(',', 'city,schedule,fields,categories,translations'),
                'filter' => [
                    'field' => 'slug',
                ],
            ]
        ));

        $item = $this->ad->getItem($slug, $params);
        $categories = $this->categoryRepository->getItemsBy(json_decode(json_encode([])));
        if (isset($item->id)) {
            return view($tpl, compact('item', 'categories'));
        } else {
            return response()->view('errors.404', [], 404);
        }
    }

    public function editAd($adId)
    {
        $params = json_decode(json_encode(
            [
                'include' => [],
                'filter' => [
                    'field' => 'id',
                    'user' => \Auth::user()->id,
                ],
            ]
        ));
        $ad = $this->ad->getItem($adId, $params);

        if (! isset($ad->id)) {
            abort(404);
        }

        $categories = $this->category->all();
        $services = $this->service->all();
        $tpl = 'Iad::frontend.adForm.edit.view';
        $ttpl = 'Iad.adForm.edit.view';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        return view($tpl, [
            'categories' => $categories,
            'services' => $services,
            'adId' => $adId,
        ]);
    }//createAd

    public function buyUp(Request $request, $adSlug)
    {
        $tpl = 'iad::frontend.buy-up';
        $ttpl = 'iad.buy-up';
        if (view()->exists($ttpl)) {
            $tpl = $ttpl;
        }

        $params = json_decode(json_encode(
            [
                'include' => explode(',', 'city,schedule,fields,categories,translations'),
                'filter' => [
                    'field' => 'slug',
                ],
            ]
        ));

        $item = $this->ad->getItem($adSlug, $params);

        if (isset($item->id)) {
            return view($tpl, compact('item'));
        } else {
            return response()->view('errors.404', [], 404);
        }
    }

    public function buyUpStore(Request $request, $pinId)
    {
        $cartService = app("Modules\Icommerce\Services\CartService");

        $data = $request->all();

        $params = json_decode(json_encode(
            [
                'include' => ['product'],
                'filter' => [
                    'status' => 1,
                ],
            ]
        ));
        $up = $this->up->getItem($data['upId'], $params);

        $products = [[
            'id' => $up->product->id,
            'quantity' => 1,
            'options' => array_merge($data, ['adId' => $pinId]),
        ]];

        if (isset($data['featured'])) {
            array_push($products, [
                'id' => config('asgard.iad.config.featuredProductId'),
                'quantity' => 1,
                'options' => ['adId' => $pinId],
            ]);
        }
        $cartService->create([
            'products' => $products,
        ]);

        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

        return redirect()->route($locale.'.icommerce.store.checkout');
    }

    private function getCategoryBreadcrumb($category)
    {
        if (config('asgard.icommerce.config.tenantWithCentralData.categories')) {
            $query = Category::whereAncestorOf($category->id, true);
            //  dd($query->toSql(),$query->getBindings());

            return CategoryTransformer::collection($query->get());
        } else {
            return CategoryTransformer::collection(Category::defaultOrder()->ancestorsAndSelf($category->id));
        }
    }
}
