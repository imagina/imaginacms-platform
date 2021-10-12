<?php

namespace Modules\Isearch\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iblog\Entities\Post;
use Modules\Isearch\Http\Requests\IsearchRequest;
use Modules\Setting\Contracts\Setting;
use Illuminate\Support\Facades\Input;

use Log;

class PublicController extends BasePublicController
{

    /**
     * @var Application
     */
    private $search;
    /**
     * @var setingRepository
     */
    private $seting;
    private $post;


    public function __construct(Setting $setting)
    {
        parent::__construct();

        $this->seting = $setting;
        $this->post = Post::query();


    }


    public function search(Request $request)
    {

        $searchphrase = $request->input('search');
        $take=12;
        if(config('asgard.isearch.config.queries.iblog') && is_module_enabled('Iblog')){
            $posts=app('Modules\Iblog\Repositories\PostRepository');
            $items=$posts->getItemsBy(json_decode(json_encode(['filter'=>['search'=>$searchphrase, 'locale' => \App::getLocale()],'page'=>$request->page??1, 'take'=> $take, 'include'=>['user']])));
            $result['post']=["title"=>trans('iblog::post.title.posts'),'items'=>$items];
        }

        if(config('asgard.isearch.config.queries.icommerce') && is_module_enabled('Icommerce')){
            $posts=app('Modules\Icommerce\Repositories\ProductRepository');
            $items=$posts->getItemsBy(json_decode(json_encode(['filter'=>['search'=>$searchphrase, 'locale' => app()->getLocale()],'page'=>$request->page??1, 'take'=> $take, 'include'=>['addedBy']])));
            $result['product']=["title"=>trans('icommerce::products.title.products'),'items'=>$items];
        }

        if(config('asgard.isearch.config.queries.iplaces') && is_module_enabled('Iplaces')){
            $posts=app('Modules\Iplaces\Repositories\PlaceRepository');
            $items=$posts->getItemsBy(json_decode(json_encode(['filter'=>['search'=>$searchphrase],'page'=>$request->page??1, 'take'=> $take, 'include'=>['user']])));
            $result['places']=["title"=>trans('iplaces::places.title.places'),'items'=>$items];
        }

        $tpl = 'isearch::index';
        $ttpl = 'isearch.index';
        if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl, compact('result', 'searchphrase'));


    }

}
