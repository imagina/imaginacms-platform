<?php

namespace Modules\Iforms\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iforms\Entities\Lead;
use Modules\Iforms\Http\Requests\CreateLeadRequest;
use Modules\Iforms\Http\Requests\UpdateLeadRequest;
use Modules\Iforms\Repositories\LeadRepository;

class LeadController extends AdminBaseController
{
    /**
     * @var LeadRepository
     */
    private $lead;

    public function __construct(LeadRepository $lead)
    {
        parent::__construct();

        $this->lead = $lead;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$leads = $this->lead->all();

        return view('iforms::admin.leads.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iforms::admin.leads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLeadRequest $request)
    {
        $this->lead->create($request->all());

        return redirect()->route('admin.iforms.lead.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iforms::leads.title.leads')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        return view('iforms::admin.leads.edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Lead $lead, UpdateLeadRequest $request)
    {
        $this->lead->update($lead, $request->all());

        return redirect()->route('admin.iforms.lead.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iforms::leads.title.leads')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $this->lead->destroy($lead);

        return redirect()->route('admin.iforms.lead.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iforms::leads.title.leads')]));
    }
}
