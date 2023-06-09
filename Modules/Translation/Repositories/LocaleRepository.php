<?php

namespace Modules\Translation\Repositories;

use Illuminate\Support\Collection;
use Modules\Translation\Http\Requests\LocaleCodeRequest;

interface LocaleRepository
{
    /**
     * Return locales filtered,sorted and paginated according to request data
     */
    public function listLocalesForSelect(LocaleCodeRequest $request): Collection;

    /**
     * Return all available locales, as config('asgard.core.available-locales')
     */
    public function availableLocales(): Collection;

    /**
     * Return same locales as app()->config->get('laravellocalization.supportedLocales')
     */
    public function supportedLocales(): Collection;

    /**
     * Return same locales as app()->config->get('translatable.locales')
     *
     * @param  array  $locales
     */
    public function translatableLocales(): Collection;
}
