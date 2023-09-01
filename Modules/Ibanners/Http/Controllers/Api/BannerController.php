<?php

namespace Modules\Ibanners\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Ibanners\Repositories\BannerRepository;
use Modules\Ibanners\Services\BannerOrderer;

class BannerController extends Controller
{
    /**
     * @var Repository
     */
    private $cache;

    /**
     * @var BannerOrderer
     */
    private $bannerOrderer;

    /**
     * @var BannerRepository
     */
    private $banner;

    public function __construct(BannerOrderer $bannerOrderer, Repository $cache, BannerRepository $banner)
    {
        $this->cache = $cache;
        $this->bannerOrderer = $bannerOrderer;
        $this->banner = $banner;
    }

    /**
     * Update all banners
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $this->cache->tags('banners')->flush();
            if ($request->input('attributes')) {
                $data = $request->input('attributes');
                $this->bannerOrderer->handle(json_encode($data['position']));
            } else {
                $this->bannerOrderer->handle($request->get('position'));
            }
            $response = ['data' => 'Order Updated'];
        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Delete a banner
     */
    public function delete(Request $request): JsonResponse
    {
        $banner = $this->banner->find($request->get('banner'));

        if (! $banner) {
            return Response::json(['errors' => true]);
        }

        $this->banner->destroy($banner);

        return Response::json(['errors' => false]);
    }
}
