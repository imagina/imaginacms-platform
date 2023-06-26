<?php

namespace Modules\Iad\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iad\Entities\Ad;
use Modules\Iad\Http\Requests\CreateAdRequest;
use Modules\Iad\Http\Requests\UpdateAdRequest;
use Modules\Iad\Repositories\AdRepository;

class AdController extends AdminBaseController
{
    /**
     * @var AdRepository
     */
    private $ad;

    public function __construct(AdRepository $ad)
    {
        parent::__construct();

        $this->ad = $ad;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$ads = $this->ad->all();

        return view('iad::admin.ads.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iad::admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAdRequest $request): Response
    {
        $this->ad->create($request->all());

        return redirect()->route('admin.iad.ad.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iad::ads.title.ads')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad): Response
    {
        return view('iad::admin.ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Ad $ad, UpdateAdRequest $request): Response
    {
        $this->ad->update($ad, $request->all());

        return redirect()->route('admin.iad.ad.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iad::ads.title.ads')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad): Response
    {
        $this->ad->destroy($ad);

        return redirect()->route('admin.iad.ad.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iad::ads.title.ads')]));
    }
}
