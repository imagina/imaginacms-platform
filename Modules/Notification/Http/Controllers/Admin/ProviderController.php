<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notification\Entities\Provider;
use Modules\Notification\Http\Requests\CreateProviderRequest;
use Modules\Notification\Http\Requests\UpdateProviderRequest;
use Modules\Notification\Repositories\ProviderRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProviderController extends AdminBaseController
{
    /**
     * @var ProviderRepository
     */
    private $provider;

    public function __construct(ProviderRepository $provider)
    {
        parent::__construct();

        $this->provider = $provider;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$providers = $this->provider->all();

        return view('notification::admin.providers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('notification::admin.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProviderRequest $request
     * @return Response
     */
    public function store(CreateProviderRequest $request)
    {
        $this->provider->create($request->all());

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::providers.title.providers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Provider $provider
     * @return Response
     */
    public function edit(Provider $provider)
    {
        return view('notification::admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Provider $provider
     * @param  UpdateProviderRequest $request
     * @return Response
     */
    public function update(Provider $provider, UpdateProviderRequest $request)
    {
        $this->provider->update($provider, $request->all());

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::providers.title.providers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Provider $provider
     * @return Response
     */
    public function destroy(Provider $provider)
    {
        $this->provider->destroy($provider);

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::providers.title.providers')]));
    }
}
