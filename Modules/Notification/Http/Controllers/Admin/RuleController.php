<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Notification\Entities\Rule;
use Modules\Notification\Http\Requests\CreateRuleRequest;
use Modules\Notification\Http\Requests\UpdateRuleRequest;
use Modules\Notification\Repositories\RuleRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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
     *
     * @return Response
     */
    public function index()
    {
        //$rules = $this->rule->all();

        return view('notification::admin.rules.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('notification::admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRuleRequest $request
     * @return Response
     */
    public function store(CreateRuleRequest $request)
    {
        $this->rule->create($request->all());

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('notification::rules.title.rules')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Rule $rule
     * @return Response
     */
    public function edit(Rule $rule)
    {
        return view('notification::admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Rule $rule
     * @param  UpdateRuleRequest $request
     * @return Response
     */
    public function update(Rule $rule, UpdateRuleRequest $request)
    {
        $this->rule->update($rule, $request->all());

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('notification::rules.title.rules')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Rule $rule
     * @return Response
     */
    public function destroy(Rule $rule)
    {
        $this->rule->destroy($rule);

        return redirect()->route('admin.notification.rule.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('notification::rules.title.rules')]));
    }
}
