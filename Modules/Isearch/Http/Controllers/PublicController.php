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
        $filter = $request->input('filter');
        isset($filter["search"]) ? $searchphrase = $filter["search"] : false;

        $tpl = 'isearch::index';
        $ttpl = 'isearch.index';
        if (view()->exists($ttpl)) $tpl = $ttpl;

        return view($tpl, compact( 'searchphrase'));


    }

}
