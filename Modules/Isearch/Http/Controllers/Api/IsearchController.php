<?php

namespace Modules\Isearch\Http\Controllers\Api;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Iblog\Entities\Post;
use Modules\Iblog\Transformers\PostTransformer;
use Modules\Setting\Contracts\Setting;

class IsearchController extends BasePublicController
{
    /**
     * @var Application
     */
    private $search;

    /**
     * @var setingRepository
     */
    private $seting;

    private $post;

    public function __construct(Setting $setting)
    {
        parent::__construct();
        $this->seting = $setting;
        $this->post = Post::query();
    }

    public function search(Request $request)
    {
        try {
            $searchphrase = $request->input('search');

            $modules = config('asgard.isearch.config.queries');

            if (isset($modules) && ! empty($modules)) {
                foreach ($modules as $k => $module) {
                    $data = $module($searchphrase);
                    if (! $data->isEmpty()) {
                        $results_post[$k] = $data;
                    }
                }
            }

            $take = 12;
            if (config('asgard.isearch.config.queries.iblog')) {
                $posts = app('Modules\Iblog\Repositories\PostRepository');
                $items = $posts->getItemsBy(json_decode(json_encode(['filter' => ['search' => $searchphrase], 'page' => $request->page ?? 1, 'take' => $take, 'include' => ['user']])));
                $result['post'] = ['title' => trans('iblog::post.title.posts'), 'items' => $items];
            }

            if (count($items)) {
                $results_post = PostTransformer::collection($items);
            }
            if (! isset($results_post) && empty($results_post)) {
                $results_post = null;
            }

            $response = [
                'data' => is_null($results_post) ? false : $results_post];
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
