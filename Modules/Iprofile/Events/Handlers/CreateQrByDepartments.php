<?php

namespace Modules\Iprofile\Events\Handlers;

use Exception;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Entities\Sentinel\User;
use Modules\Iprofile\Events\ImpersonateEvent;
use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Http\Requests\ResetCompleteRequest;
use Modules\User\Http\Requests\ResetRequest;
use Modules\User\Services\UserResetter;
use Socialite;
use Modules\User\Contracts\Authentication;

class CreateQrByDepartments
{

  public $qrService;

  public function __construct()
  {

  }

  public function handle($event)
  {
    if(is_module_enabled('Qreable')){
      $this->qrService = app("Modules\Qreable\Services\QrService");
      try {
        $user = $event->user;
        $departments = $user->departments;
        foreach ($departments as $department) {
          if ($department->is_internal) {
            $this->qrService->addQr($user,'/account/vcard/'.$user->id,'vcard');
          }
        }
      } catch (\Exception $e) {
        \Log::error('Iprofile: Events|Handlers|CreateQrByDepartments|Message: ' . $e->getMessage() . ' | FILE: ' . $e->getFile() . ' | LINE: ' . $e->getLine());
      }
    }
  }
}