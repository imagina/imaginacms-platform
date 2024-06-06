<?php

namespace Modules\Iprofile\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Iprofile\Entities\Address;
use Modules\Iprofile\Http\Requests\CreateAddressRequest;
use Modules\Iprofile\Http\Requests\UpdateAddressRequest;
use Modules\Iprofile\Repositories\AddressRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AddressController extends AdminBaseController
{
    /**
     * @var AddressRepository
     */
    private $address;

    public function __construct(AddressRepository $address)
    {
        parent::__construct();

        $this->address = $address;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$addresses = $this->address->all();

        return view('iprofile::admin.addresses.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('iprofile::admin.addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAddressRequest $request
     * @return Response
     */
    public function store(CreateAddressRequest $request)
    {
        $this->address->create($request->all());

        return redirect()->route('admin.iprofile.address.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iprofile::addresses.title.addresses')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Address $address
     * @return Response
     */
    public function edit(Address $address)
    {
        return view('iprofile::admin.addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Address $address
     * @param  UpdateAddressRequest $request
     * @return Response
     */
    public function update(Address $address, UpdateAddressRequest $request)
    {
        $this->address->update($address, $request->all());

        return redirect()->route('admin.iprofile.address.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iprofile::addresses.title.addresses')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Address $address
     * @return Response
     */
    public function destroy(Address $address)
    {
        $this->address->destroy($address);

        return redirect()->route('admin.iprofile.address.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iprofile::addresses.title.addresses')]));
    }
}
