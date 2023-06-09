<?php

namespace Modules\Translation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Translation\Services\TranslationsService;
use Modules\Translation\Transformers\TranslationApiTransformer;

class AllTranslationApiController extends BaseApiController
{
    private $translationsService;

    public function __construct(TranslationsService $translationsService)
    {
        $this->translationsService = $translationsService;
    }

    public function index(Request $request)
    {
        $params = $this->getParamsRequest($request);
        $allModulesTrans = $this->translationsService->getFileAndDatabaseMergedTranslations();

        $translations = $allModulesTrans->all()->toArray();

        $returnedTranslations = [];

        foreach ($translations as $key => $translation) {
            //Filter by search
            if (isset($params->filter->search) && ! empty($params->filter->search)) {
                if (! Str::contains($key, $params->filter->search) && ! Str::contains(json_encode($translation), $params->filter->search)) {
                    continue;
                }
            }

            $returnedTranslation = ['key' => $key];
            foreach ($translation as $locale => $value) {
                $returnedTranslation[$locale] = ['value' => $value];
            }

            $returnedTranslations[] = $returnedTranslation;
        }

        if (isset($params->page) && $params->page) {
            $returnedTranslations = $this->paginate($returnedTranslations, $params->take);
        }

        $response['data'] = json_decode(json_encode(TranslationApiTransformer::collection($returnedTranslations)));
        $response['data'] = array_values(collect($response['data'])->toArray());
        $params->page ? $response['meta'] = ['page' => $this->pageTransformer($returnedTranslations)] : false;

        return response()->json($response, 200);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
