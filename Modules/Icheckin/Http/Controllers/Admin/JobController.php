<?php

namespace Modules\Icheckin\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Icheckin\Entities\Job;
use Modules\Icheckin\Http\Requests\CreateJobRequest;
use Modules\Icheckin\Http\Requests\UpdateJobRequest;
use Modules\Icheckin\Repositories\JobRepository;

class JobController extends AdminBaseController
{
    /**
     * @var JobRepository
     */
    private $job;

    public function __construct(JobRepository $job)
    {
        parent::__construct();

        $this->job = $job;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$jobs = $this->job->all();

        return view('icheckin::admin.jobs.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('icheckin::admin.jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateJobRequest $request): Response
    {
        $this->job->create($request->all());

        return redirect()->route('admin.icheckin.job.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icheckin::jobs.title.jobs')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job): Response
    {
        return view('icheckin::admin.jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Job $job, UpdateJobRequest $request): Response
    {
        $this->job->update($job, $request->all());

        return redirect()->route('admin.icheckin.job.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icheckin::jobs.title.jobs')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job): Response
    {
        $this->job->destroy($job);

        return redirect()->route('admin.icheckin.job.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icheckin::jobs.title.jobs')]));
    }
}
