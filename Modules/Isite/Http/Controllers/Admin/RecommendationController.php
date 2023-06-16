<?php

namespace Modules\Isite\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Isite\Entities\Recommendation;
use Modules\Isite\Http\Requests\CreateRecommendationRequest;
use Modules\Isite\Http\Requests\UpdateRecommendationRequest;
use Modules\Isite\Repositories\RecommendationRepository;

class RecommendationController extends AdminBaseController
{
    /**
     * @var RecommendationRepository
     */
    private $recommendation;

    public function __construct(RecommendationRepository $recommendation)
    {
        parent::__construct();

        $this->recommendation = $recommendation;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$recommendations = $this->recommendation->all();

        return view('isite::admin.recommendations.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('isite::admin.recommendations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateRecommendationRequest $request)
    {
        $this->recommendation->create($request->all());

        return redirect()->route('admin.isite.recommendation.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('isite::recommendations.title.recommendations')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Recommendation $recommendation)
    {
        return view('isite::admin.recommendations.edit', compact('recommendation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Recommendation $recommendation, UpdateRecommendationRequest $request)
    {
        $this->recommendation->update($recommendation, $request->all());

        return redirect()->route('admin.isite.recommendation.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('isite::recommendations.title.recommendations')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Recommendation $recommendation)
    {
        $this->recommendation->destroy($recommendation);

        return redirect()->route('admin.isite.recommendation.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('isite::recommendations.title.recommendations')]));
    }
}
