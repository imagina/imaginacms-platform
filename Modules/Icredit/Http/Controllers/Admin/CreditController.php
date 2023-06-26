<?php

namespace Modules\Icredit\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icredit\Entities\Credit;
use Modules\Icredit\Http\Requests\CreateCreditRequest;
use Modules\Icredit\Http\Requests\UpdateCreditRequest;
use Modules\Icredit\Repositories\CreditRepository;

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
     */
    public function index(): Response
    {
        //$credits = $this->credit->all();

        return view('icredit::admin.credits.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icredit::admin.credits.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCreditRequest $request): Response
    {
        $this->credit->create($request->all());

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icredit::credits.title.credits')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Credit $credit): Response
    {
        return view('icredit::admin.credits.edit', compact('credit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Credit $credit, UpdateCreditRequest $request): Response
    {
        $this->credit->update($credit, $request->all());

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icredit::credits.title.credits')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Credit $credit): Response
    {
        $this->credit->destroy($credit);

        return redirect()->route('admin.icredit.credit.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icredit::credits.title.credits')]));
    }
}
