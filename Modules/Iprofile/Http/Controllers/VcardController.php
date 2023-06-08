<?php

namespace Modules\Iprofile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Setting\Contracts\Setting;

//**** Iprofile
use Modules\Iprofile\Repositories\UserApiRepository;

//**** User
use Modules\User\Repositories\UserRepository;
use Modules\User\Contracts\Authentication;

//**** Vcard
use JeroenDesloovere\VCard\VCard;
use Illuminate\Support\Facades\Storage;
class VcardController extends AdminBaseController
{

  private $auth;
  private $user;
  private $userApi;

  public function __construct(

    Authentication    $auth,
    UserRepository    $user,
    UserApiRepository $userApi

  )
  {
    parent::__construct();

    $this->auth = $auth;
    $this->user = $user;
    $this->userApi = $userApi;

  }

  public function create($userID)
  {

    $user = $this->userApi->getItem($userID);

    $vcard = new VCard();

    // add personal data
    $vcard->addName($user->last_name, $user->first_name, '', '', '');

    // add work data
    $vcard->addCompany(setting("core::site-name"));
    $vcard->addJobtitle($user->settings->where("name", "jobTitle")->first()->value ?? "");
    $vcard->addRole($user->settings->where("name", "jobRole")->first()->value ?? "");
    $vcard->addEmail($user->settings->where("name", "jobEmail")->first()->value ?? $user->email);
    $vcard->addPhoneNumber($user->settings->where("name", "jobMobile")->first()->value ?? "", 'PREF;WORK');
    
    $defaultImage = 'modules/iprofile/img/default.jpg';
    $mainImage = !$user->fields->isEmpty() ? $user->fields->where('name', 'mainImage')->first() : null;
    
    if (!is_null($mainImage)) {
      $contents = Storage::disk("publicmedia")->path($mainImage->value->getRelativeUrl());
      $vcard->addPhoto($contents);
    } else {
      $contents = Storage::disk("publicmedia")->path($defaultImage);
      $vcard->addPhoto(url($defaultImage));
    }

//    return $vcard->getOutput();

    // return vcard as a download
    //return $vcard->download();
  
    return Response::make(
      $vcard->getOutput(),
      200,
      $vcard->getHeaders(true)
    );
  }

}
