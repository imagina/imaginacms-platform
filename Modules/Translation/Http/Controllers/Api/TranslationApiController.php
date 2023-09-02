<?php

namespace Modules\Translation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\Translation\Repositories\TranslationRepository;
use Modules\Translation\Services\TranslationRevisions;
use Modules\Translation\Services\TranslationsService;
use Modules\Translation\Transformers\TranslationApiTransformer;
use Modules\User\Traits\CanFindUserWithBearerToken;

class TranslationApiController extends BaseApiController
{
    use CanFindUserWithBearerToken;

    /**
     * @var TranslationRepository
     */
    private $translation;

    private $translationsService;

    public function __construct(TranslationRepository $translation)
    {
        $this->translation = $translation;
        $this->translationsService = app(TranslationsService::class);
    }

    public function show($criteria, Request $request)
    {
        try {
            $translations = $this->translationsService->getFileAndDatabaseMergedTranslations()->all()->toArray();

            //Break if no found item
            if (! array_key_exists($criteria, $translations)) {
                throw new \Exception('Item not found', 404);
            }

            $tr = $translations[$criteria];
            $translation = ['key' => $criteria];

            foreach ($tr as $locale => $value) {
                $translation[$locale] = ['value' => $value];
            }

            $translation = collect($translation);

            //Response
            $response = ['data' => new TranslationApiTransformer($translation)];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response);
    }

    public function create(Request $request)
    {
        $data = $request->input('attributes') ?? []; //Get data
        $languages = \LaravelLocalization::getSupportedLocales();
        foreach ($languages as $lang => $value) {
            $this->translation->saveTranslationForLocaleAndKey(
                $lang,
                $data['key'],
                $data[$lang]['value'],
            );
        }

        return response()->json(['data' => 'Translation created Successfully']);
    }

    public function update($criteria, Request $request)
    {
        $data = $request->input('attributes') ?? []; //Get data

        $languages = \LaravelLocalization::getSupportedLocales();

        foreach ($languages as $lang => $value) {
            $this->translation->saveTranslationForLocaleAndKey(
                $lang,
                $criteria,
                $data[$lang]['value'],
            );
        }

        return response()->json(['data' => 'Translation updated Successfully']);
    }

    public function clearCache()
    {
        $this->translation->clearCache();

        return response()->json(['data' => 'Translation Cache cleared Successfully']);
    }

    public function revisions(TranslationRevisions $revisions, Request $request)
    {
        return $revisions->get(
            $request->get('key'),
            $request->get('locale')
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($key, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            //Delete data
            $this->translation->deleteBy($key, $params);

            //Response
            $response = ['data' => 'Translation deleted Successfully'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }
}
