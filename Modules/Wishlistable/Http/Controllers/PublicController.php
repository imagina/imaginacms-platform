<?php

namespace Modules\Wishlistable\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class PublicController extends BaseApiController
{
    protected $auth;

    public function __construct(

  ) {
        parent::__construct();
    }

    // view products by category
    public function index(Request $request)
    {
        $tpl = 'wishlistable::frontend.wishlist.index';

        //Validation with lang from URL
        $result = validateLocaleFromUrl($request, [
            'fixedTrans' => 'wishlistable::routes.wishlist.index',
        ]);
        if (isset($result['reedirect'])) {
            return redirect()->to($result['url']);
        }

        return view($tpl);
    }
}
