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
     */
    public function index(): Response
    {
        //$transactions = $this->transaction->all();

        return view('icommercecredibanco::admin.transactions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icommercecredibanco::admin.transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTransactionRequest $request): Response
    {
        $this->transaction->create($request->all());

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction): Response
    {
        return view('icommercecredibanco::admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Transaction $transaction, UpdateTransactionRequest $request): Response
    {
        $this->transaction->update($transaction, $request->all());

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction): Response
    {
        $this->transaction->destroy($transaction);

        return redirect()->route('admin.icommercecredibanco.transaction.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommercecredibanco::transactions.title.transactions')]));
    }
}
