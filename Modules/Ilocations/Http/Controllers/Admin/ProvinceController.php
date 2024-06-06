<?php

namespace Modules\Ilocations\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ilocations\Entities\Province;
use Modules\Ilocations\Http\Requests\CreateProvinceRequest;
use Modules\Ilocations\Http\Requests\UpdateProvinceRequest;
use Modules\Ilocations\Repositories\ProvinceRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ProvinceController extends AdminBaseController
{
    /**
     * @var ProvinceRepository
     */
    private $province;

    public function __construct(ProvinceRepository $province)
    {
        parent::__construct();

        $this->province = $province;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$provinces = $this->province->all();

        return view('ilocations::admin.provinces.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ilocations::admin.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProvinceRequest $request
     * @return Response
     */
    public function store(CreateProvinceRequest $request)
    {
        $this->province->create($request->all());

        return redirect()->route('admin.ilocations.province.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ilocations::provinces.title.provinces')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Province $province
     * @return Response
     */
    public function edit(Province $province)
    {
        return view('ilocations::admin.provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Province $province
     * @param  UpdateProvinceRequest $request
     * @return Response
     */
    public function update(Province $province, UpdateProvinceRequest $request)
    {
        $this->province->update($province, $request->all());

        return redirect()->route('admin.ilocations.province.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ilocations::provinces.title.provinces')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Province $province
     * @return Response
     */
    public function destroy(Province $province)
    {
        $this->province->destroy($province);

        return redirect()->route('admin.ilocations.province.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ilocations::provinces.title.provinces')]));
    }
}
