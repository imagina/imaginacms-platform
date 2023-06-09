<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\Provider;
use Modules\Notification\Http\Requests\CreateProviderRequest;
use Modules\Notification\Http\Requests\UpdateProviderRequest;
use Modules\Notification\Repositories\ProviderRepository;

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
     */
    public function index(): Response
    {
        //$providers = $this->provider->all();

        return view('notification::admin.providers.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('notification::admin.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProviderRequest $request): Response
    {
        $this->provider->create($request->all());

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::providers.title.providers')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider): Response
    {
        return view('notification::admin.providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Provider $provider, UpdateProviderRequest $request): Response
    {
        $this->provider->update($provider, $request->all());

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::providers.title.providers')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider): Response
    {
        $this->provider->destroy($provider);

        return redirect()->route('admin.notification.provider.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::providers.title.providers')]));
    }
}
