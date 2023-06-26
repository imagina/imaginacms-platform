<?php

namespace Modules\Icheckin\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icheckin\Entities\Approvals;
use Modules\Icheckin\Http\Requests\CreateApprovalRequest;
use Modules\Icheckin\Http\Requests\UpdateApprovalRequest;
use Modules\Icheckin\Repositories\ApprovalRepository;

class ApprovalController extends AdminBaseController
{
    /**
     * @var ApprovalRepository
     */
    private $approval;

    public function __construct(ApprovalRepository $approval)
    {
        parent::__construct();

        $this->approval = $approval;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$approvals = $this->approval->all();

        return view('icheckin::admin.approvals.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('icheckin::admin.approvals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateApprovalRequest $request): Response
    {
        $this->approval->create($request->all());

        return redirect()->route('admin.icheckin.approval.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icheckin::approvals.title.approvals')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Approvals $approval): Response
    {
        return view('icheckin::admin.approvals.edit', compact('approval'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Approvals $approval, UpdateApprovalRequest $request): Response
    {
        $this->approval->update($approval, $request->all());

        return redirect()->route('admin.icheckin.approval.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icheckin::approvals.title.approvals')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Approvals $approval): Response
    {
        $this->approval->destroy($approval);

        return redirect()->route('admin.icheckin.approval.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icheckin::approvals.title.approvals')]));
    }
}
