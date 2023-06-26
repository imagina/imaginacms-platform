<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iprofile\Entities\UserApi;
use Modules\Iprofile\Http\Requests\CreateUserApiRequest;
use Modules\Iprofile\Http\Requests\UpdateUserApiRequest;
use Modules\Iprofile\Repositories\UserApiRepository;

class UserApiController extends AdminBaseController
{
    /**
     * @var UserApiRepository
     */
    private $userapi;

    public function __construct(UserApiRepository $userapi)
    {
        parent::__construct();

        $this->userapi = $userapi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$userapis = $this->userapi->all();

        return view('Iprofile::admin.userapis.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('Iprofile::admin.userapis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUserApiRequest $request): Response
    {
        $this->userapi->create($request->all());

        return redirect()->route('admin.Iprofile.userapi.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('Iprofile::userapis.title.userapis')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(UserApi $userapi): Response
    {
        return view('Iprofile::admin.userapis.edit', compact('userapi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UserApi $userapi, UpdateUserApiRequest $request): Response
    {
        $this->userapi->update($userapi, $request->all());

        return redirect()->route('admin.Iprofile.userapi.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('Iprofile::userapis.title.userapis')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(UserApi $userapi): Response
    {
        $this->userapi->destroy($userapi);

        return redirect()->route('admin.Iprofile.userapi.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('Iprofile::userapis.title.userapis')]));
    }
}
