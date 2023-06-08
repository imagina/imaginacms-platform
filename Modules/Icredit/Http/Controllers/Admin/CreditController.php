<?php

namespace Modules\Icredit\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Http\Requests\CreateCreditRequest;
use Modules\Icredit\Http\Requests\UpdateCreditRequest;
use Modules\Icredit\Repositories\CreditRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CreditController extends AdminBaseController
{
    /**
     * @var CreditRepository
     */
    private $credit;

    public function __construct(CreditRepository $credit)
    {
        parent::__construct();

        $this->credit = $credit;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$credits = $this->credit->all();

        return view('icredit::admin.credits.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icredit::admin.credits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCreditRequest $request
     * @return Response
     */
    public function store(CreateCreditRequest $request)
    {
        $this->credit->create($request->all());

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icredit::credits.title.credits')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Credit $credit
     * @return Response
     */
    public function edit(Credit $credit)
    {
        return view('icredit::admin.credits.edit', compact('credit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Credit $credit
     * @param  UpdateCreditRequest $request
     * @return Response
     */
    public function update(Credit $credit, UpdateCreditRequest $request)
    {
        $this->credit->update($credit, $request->all());

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icredit::credits.title.credits')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Credit $credit
     * @return Response
     */
    public function destroy(Credit $credit)
    {
        $this->credit->destroy($credit);

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icredit::credits.title.credits')]));
    }
}
