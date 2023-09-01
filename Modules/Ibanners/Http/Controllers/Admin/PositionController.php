<?php

namespace Modules\Ibanners\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ibanners\Entities\Position;
use Modules\Ibanners\Http\Requests\CreatePositionRequest;
use Modules\Ibanners\Http\Requests\UpdatePositionRequest;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Ibanners\Repositories\PositionRepository;
use Modules\Ibanners\Services\PositionRenderer;

class PositionController extends AdminBaseController
{
    /**
     * @var PositionRepository
     */
    private $position;

    /**
     * @var BannerRepository
     */
    private $banner;

    /**
     * @var PositionRenderer
     */
    private $positionRenderer;

    public function __construct(
        PositionRepository $position,
        BannerRepository $banner,
        PositionRenderer $positionRenderer
    ) {
        parent::__construct();
        $this->position = $position;
        $this->banner = $banner;
        $this->positionRenderer = $positionRenderer;
    }

    public function index()
    {
        $positions = $this->position->all();

        return view('ibanners::admin.positions.index')
            ->with([
                'positions' => $positions,
            ]);
    }

    public function create()
    {
        return view('ibanners::admin.positions.create');
    }

    public function store(CreatePositionRequest $request)
    {
        $this->position->create($request->all());

        return redirect()->route('admin.ibanners.position.index')->withSuccess(trans('ibanners::messages.position created'));
    }

    public function edit(Position $position)
    {
        $banners = $position->banners;
        $positionStructure = $this->positionRenderer->renderForPosition($position, $banners);

        return view('ibanners::admin.positions.edit')
            ->with([
                'position' => $position,
                'banners' => $positionStructure,
            ]);
    }

    public function update(Position $position, UpdatePositionRequest $request)
    {
        $this->position->update($position, $request->all());

        return redirect()->route('admin.ibanners.position.index')->withSuccess(trans('ibanners::messages.position updated'));
    }

    public function destroy(Position $position)
    {
        $this->position->destroy($position);

        return redirect()->route('admin.ibanners.position.index')->withSuccess(trans('ibanners::messages.position deleted'));
    }
}
