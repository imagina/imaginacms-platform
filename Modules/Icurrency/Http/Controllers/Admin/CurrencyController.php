<?php

namespace Modules\Icurrency\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icurrency\Entities\Currency;
use Modules\Icurrency\Http\Requests\CreateCurrencyRequest;
use Modules\Icurrency\Http\Requests\UpdateCurrencyRequest;
use Modules\Icurrency\Repositories\CurrencyRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     * @param  CreateCurrencyRequest $request
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
     * @param  Currency $currency
     * @return Response
     */
    public function edit(Currency $currency)
    {
        return view('icurrency::admin.currencies.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Currency $currency
     * @param  UpdateCurrencyRequest $request
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
     * @param  Currency $currency
     * @return Response
     */
    public function destroy(Currency $currency)
    {
        $this->currency->destroy($currency);

        return redirect()->route('admin.icurrency.currency.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icurrency::currencies.title.currencies')]));
    }
}
