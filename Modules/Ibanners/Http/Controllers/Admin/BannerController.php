<?php

namespace Modules\Ibanners\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ibanners\Entities\Banner;
use Modules\Ibanners\Entities\Position;
use Modules\Ibanners\Http\Requests\CreateBannerRequest;
use Modules\Ibanners\Http\Requests\UpdateBannerRequest;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Media\Repositories\FileRepository;

class BannerController extends AdminBaseController
{
    /**
     * @var BannerRepository
     */
    private $banner;

    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(BannerRepository $banner, FileRepository $file)
    {
        parent::__construct();
        $this->banner = $banner;
        $this->file = $file;
    }

    public function create(Position $position)
    {
        return view('ibanners::admin.banners.create')
            ->with([
                'position' => $position,
            ]);
    }

    public function store(Position $position, CreateBannerRequest $request)
    {
        $this->banner->create($this->addPositionId($position, $request));

        return redirect()
            ->route('admin.ibanners.position.edit', [$position->id])
            ->withSuccess(trans('ibanners::messages.banner created'));
    }

    public function edit(Position $position, Banner $banner)
    {
        return view('ibanners::admin.banners.edit')
            ->with([
                'position' => $position,
                'banner' => $banner,
                'bannerimage' => $this->file->findFileByZoneForEntity('bannerimage', $banner),
            ]);
    }

    public function update(Position $position, Banner $banner, UpdateBannerRequest $request)
    {
        $this->banner->update($banner, $this->addPositionId($position, $request));

        return redirect()
            ->route('admin.ibanners.position.edit', [$position->id])
            ->withSuccess(trans('ibanners::messages.banner updated'));
    }

    private function addPositionId(Position $position, FormRequest $request): array
    {
        return array_merge($request->all(), ['position_id' => $position->id]);
    }
}
