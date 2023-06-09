<?php

namespace Modules\Iprofile\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
//**** Iprofile
use Modules\Iprofile\Http\Controllers\Api\FieldApiController;
use Modules\Iprofile\Repositories\UserApiRepository;
//**** User
use Modules\User\Contracts\Authentication;
use Modules\User\Repositories\UserRepository;

class ProfileController extends AdminBaseController
{
    private $auth;

    private $user;

    private $userApi;

    private $fieldApi;

    private $categoriesPlaces;

    private $storable;

    public function __construct(
    Authentication $auth,
    UserRepository $user,
    UserApiRepository $userApi,
    FieldApiController $fieldApi
  ) {
        parent::__construct();

        $this->auth = $auth;
        $this->user = $user;
        $this->userApi = $userApi;
        $this->fieldApi = $fieldApi;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = $this->auth->user();
        $user = $this->userApi->getItem($user->id, (object) [
            'take' => false,
            'include' => ['fields', 'roles'],
        ]);

        // Fix fields to frontend
        $fields = [];
        if (isset($user->fields) && ! empty($user->fields)) {
            foreach ($user->fields as $f) {
                $fields[$f->name] = $f->value;
            }
        }

        $tpl = 'iprofile::frontend.index';

        return view($tpl, compact('user', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Profile  $profile
     */
    public function update($userID, Request $request): Response
    {
        $user = $this->auth->user();

        $userWR = $this->userApi->getItem($user->id, (object) [
            'take' => false,
            'include' => ['fields'],
        ]);

        $userField = $userWR->fields;

        try {
            //Get data
            $data = $request->all();

            // Update data User
            $this->user->update($user, $data);

            //Create or Update fields
            if (isset($data['fields'])) {
                $field = [];
                foreach ($data['fields'] as $key => $value) {
                    if (! empty($value) && $value != null) {
                        $field['user_id'] = $user->id; // Add user Id
                        $field['value'] = $value;
                        $field['name'] = $key;

                        if (count($userField) > 0) {
                            $entity = $userField->where('name', $key)->first();
                        }

                        if (isset($entity)) {
                            $this->fieldApi->update($entity->id, new Request(['attributes' => $field]));
                        } else {
                            $this->fieldApi->create(new Request(['attributes' => $field]));
                        }
                    }
                }// End Foreach
            }// End If
            $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();

            return redirect()->route($locale.'.iprofile.account.index')
              ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans(
                  'iprofile::frontend.title.profile')]));
        } catch (\Throwable $t) {
            $response['status'] = 'error';
            $response['message'] = $t->getMessage();
            Log::error($t);

            echo $t->getMessage();

            return redirect()->route('account.register')
              ->withError($response['message']);
        }
    }
}
