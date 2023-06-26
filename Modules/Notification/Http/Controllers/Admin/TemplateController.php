<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\Template;
use Modules\Notification\Http\Requests\CreateTemplateRequest;
use Modules\Notification\Http\Requests\UpdateTemplateRequest;
use Modules\Notification\Repositories\TemplateRepository;

class TemplateController extends AdminBaseController
{
    /**
     * @var TemplateRepository
     */
    private $template;

    public function __construct(TemplateRepository $template)
    {
        parent::__construct();

        $this->template = $template;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        //$templates = $this->template->all();

        return view('notification::admin.templates.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return view('notification::admin.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateTemplateRequest $request): Response
    {
        $this->template->create($request->all());

        return redirect()->route('admin.notification.template.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::templates.title.templates')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Template $template): Response
    {
        return view('notification::admin.templates.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Template $template, UpdateTemplateRequest $request): Response
    {
        $this->template->update($template, $request->all());

        return redirect()->route('admin.notification.template.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::templates.title.templates')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Template $template): Response
    {
        $this->template->destroy($template);

        return redirect()->route('admin.notification.template.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::templates.title.templates')]));
    }
}
