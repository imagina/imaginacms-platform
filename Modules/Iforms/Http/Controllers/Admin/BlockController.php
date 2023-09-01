<?php

namespace Modules\Iforms\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iforms\Entities\Block;
use Modules\Iforms\Http\Requests\CreateBlockRequest;
use Modules\Iforms\Http\Requests\UpdateBlockRequest;
use Modules\Iforms\Repositories\BlockRepository;

class BlockController extends AdminBaseController
{
    /**
     * @var BlockRepository
     */
    private $block;

    public function __construct(BlockRepository $block)
    {
        parent::__construct();

        $this->block = $block;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //$blocks = $this->block->all();

        return view('iforms::admin.blocks.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return view('iforms::admin.blocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlockRequest $request): Response
    {
        $this->block->create($request->all());

        return redirect()->route('admin.iforms.block.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iforms::blocks.title.blocks')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Block $block): Response
    {
        return view('iforms::admin.blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Block $block, UpdateBlockRequest $request): Response
    {
        $this->block->update($block, $request->all());

        return redirect()->route('admin.iforms.block.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iforms::blocks.title.blocks')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Block $block): Response
    {
        $this->block->destroy($block);

        return redirect()->route('admin.iforms.block.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iforms::blocks.title.blocks')]));
    }
}
