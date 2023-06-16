<?php

namespace Modules\Icurrency\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icurrency\Entities\Currency;
use Modules\Icurrency\Http\Requests\CreateCurrencyRequest;
use Modules\Icurrency\Http\Requests\UpdateCurrencyRequest;
use Modules\Icurrency\Repositories\CurrencyRepository;

class CurrencyController extends AdminBaseController
{
    /**
     * @var CurrencyRepository
     */
    private $currency;

    public function __construct(CurrencyRepository $currency)
    {
        parent::__construct();

        $this->currency = $currency;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$currencies = $this->currency->all();

        return view('icurrency::admin.currencies.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icurrency::admin.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateCurrencyRequest $request)
    {
        $this->currency->create($request->all());

        return redirect()->route('admin.icurrency.currency.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icurrency::currencies.title.currencies')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Currency $currency)
    {
        return view('icurrency::admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Currency $currency, UpdateCurrencyRequest $request)
    {
        $this->currency->update($currency, $request->all());

        return redirect()->route('admin.icurrency.currency.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icurrency::currencies.title.currencies')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Currency $currency)
    {
        $this->currency->destroy($currency);

        return redirect()->route('admin.icurrency.currency.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icurrency::currencies.title.currencies')]));
    }
}
