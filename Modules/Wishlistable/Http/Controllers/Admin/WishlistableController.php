<?php

namespace Modules\Wishlistable\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Wishlistable\Entities\Wishlistable;
use Modules\Wishlistable\Http\Requests\CreateWishlistableRequest;
use Modules\Wishlistable\Http\Requests\UpdateWishlistableRequest;
use Modules\Wishlistable\Repositories\WishlistableRepository;

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
     */
    public function index(): Response
    {
        //$wishlistables = $this->wishlistable->all();

        return view('wishlistable::admin.wishlistables.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('wishlistable::admin.wishlistables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateWishlistableRequest $request): Response
    {
        $this->wishlistable->create($request->all());

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlistable $wishlistable): Response
    {
        return view('wishlistable::admin.wishlistables.edit', compact('wishlistable'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Wishlistable $wishlistable, UpdateWishlistableRequest $request): Response
    {
        $this->wishlistable->update($wishlistable, $request->all());

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlistable $wishlistable): Response
    {
        $this->wishlistable->destroy($wishlistable);

        return redirect()->route('admin.wishlistable.wishlistable.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('wishlistable::wishlistables.title.wishlistables')]));
    }
}
