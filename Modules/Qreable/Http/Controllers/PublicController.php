<?php


namespace Modules\Qreable\Http\Controllers;

use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;


class PublicController extends BaseApiController
{

    private $user;

    public function __construct()
    {
        $this->user = app("Modules\Iprofile\Repositories\UserApiRepository");
    }

    function myQrs(){
        $user = $this->user->getItem(auth()->user()->id, (object)[
            'take' => false,
            'include' => ['fields', 'roles']
        ]);

        // Fix fields to frontend
        $fields = [];
        if (isset($user->fields) && !empty($user->fields)) {
            foreach ($user->fields as $f) {
                $fields[$f->name] = $f->value;
            }
        }

        $tpl = 'qreable::frontend.my-qrs';
        $ttpl = 'qreable.my-qrs';

        return view($tpl, compact('user','fields'));
    }

}
