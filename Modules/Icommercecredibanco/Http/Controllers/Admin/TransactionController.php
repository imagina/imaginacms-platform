<?php

namespace Modules\Icommercecredibanco\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icommercecredibanco\Entities\Transaction;
use Modules\Icommercecredibanco\Http\Requests\CreateTransactionRequest;
use Modules\Icommercecredibanco\Http\Requests\UpdateTransactionRequest;
use Modules\Icommercecredibanco\Repositories\TransactionRepository;

class TransactionController extends AdminBaseController
{
    /**
     * @var TransactionRepository
     */
    private $transaction;

    public function __construct(TransactionRepository $transaction)
    {
        parent::__construct();

        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$transactions = $this->transaction->all();

        return view('icommercecredibanco::admin.transactions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommercecredibanco::admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $this->transaction->create($request->all());

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Transaction $transaction)
    {
        return view('icommercecredibanco::admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Transaction $transaction, UpdateTransactionRequest $request)
    {
        $this->transaction->update($transaction, $request->all());

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Transaction $transaction)
    {
        $this->transaction->destroy($transaction);

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }
}