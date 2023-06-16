<?php

namespace Modules\Iredirect\Http\Controllers;

use Modules\Core\Http\Controllers\BasePublicController;

class PublicController extends BasePublicController
{
    /**
     * @var RedirectRepository
     */
    private $redirect;

    public function __construct(RedirectRepository $redirect)
    {
        parent::__construct();
        $this->redirect = $redirect;
    }

    public function index()
    {
    }
}
