<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Notification\Entities\Rule;
use Modules\Notification\Http\Requests\CreateRuleRequest;
use Modules\Notification\Http\Requests\UpdateRuleRequest;
use Modules\Notification\Repositories\RuleRepository;

class RuleController extends AdminBaseController
{
    /**
     * @var RuleRepository
     */
    private $rule;

    public function __construct(RuleRepository $rule)
    {
        parent::__construct();

        $this->rule = $rule;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$rules = $this->rule->all();

        return view('notification::admin.rules.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('notification::admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRuleRequest $request): Response
    {
        $this->rule->create($request->all());

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::rules.title.rules')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule): Response
    {
        return view('notification::admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Rule $rule, UpdateRuleRequest $request): Response
    {
        $this->rule->update($rule, $request->all());

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::rules.title.rules')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule): Response
    {
        $this->rule->destroy($rule);

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::rules.title.rules')]));
    }
}
