<?php

namespace Modules\Slider\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Slider\Repositories\SlideRepository;
use Modules\Slider\Services\SlideOrderer;

class SlideController extends Controller
{
    /**
     * @var Repository
     */
    private $cache;

    /**
     * @var SlideOrderer
     */
    private $slideOrderer;

    /**
     * @var SlideRepository
     */
    private $slide;

    public function __construct(SlideOrderer $slideOrderer, Repository $cache, SlideRepository $slide)
    {
        $this->cache = $cache;
        $this->slideOrderer = $slideOrderer;
        $this->slide = $slide;
    }

    /**
     * Update all slides
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $this->cache->tags('slides')->flush();
            if ($request->input('attributes')) {
                $data = $request->input('attributes');
                $this->slideOrderer->handle(json_encode($data['slider']));
            } else {
                $this->slideOrderer->handle($request->get('slider'));
            }
            $response = ['data' => 'Order Updated'];
        } catch (\Exception $e) {
            $status = 500;
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Delete a slide
     */
    public function delete(Request $request): JsonResponse
    {
        $slide = $this->slide->find($request->get('slide'));

        if (! $slide) {
            return Response::json(['errors' => true]);
        }

        $this->slide->destroy($slide);

        return Response::json(['errors' => false]);
    }
}
