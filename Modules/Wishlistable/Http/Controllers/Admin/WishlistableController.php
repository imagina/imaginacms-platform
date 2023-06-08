<?php

namespace Modules\Wishlistable\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wishlistable\Entities\Wishlistable;
use Modules\Wishlistable\Http\Requests\CreateWishlistableRequest;
use Modules\Wishlistable\Http\Requests\UpdateWishlistableRequest;
use Modules\Wishlistable\Repositories\WishlistableRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class WishlistableController extends AdminBaseController
{
    /**
     * @var WishlistableRepository
     */
    private $wishlistable;

    public function __construct(WishlistableRepository $wishlistable)
    {
        parent::__construct();

        $this->wishlistable = $wishlistable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$wishlistables = $this->wishlistable->all();

        return view('wishlistable::admin.wishlistables.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('wishlistable::admin.wishlistables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWishlistableRequest $request
     * @return Response
     */
    public function store(CreateWishlistableRequest $request)
    {
        $this->wishlistable->create($request->all());

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Wishlistable $wishlistable
     * @return Response
     */
    public function edit(Wishlistable $wishlistable)
    {
        return view('wishlistable::admin.wishlistables.edit', compact('wishlistable'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Wishlistable $wishlistable
     * @param  UpdateWishlistableRequest $request
     * @return Response
     */
    public function update(Wishlistable $wishlistable, UpdateWishlistableRequest $request)
    {
        $this->wishlistable->update($wishlistable, $request->all());

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Wishlistable $wishlistable
     * @return Response
     */
    public function destroy(Wishlistable $wishlistable)
    {
        $this->wishlistable->destroy($wishlistable);

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }
}
