<?php

namespace Modules\Translation\Repositories;

use Modules\Core\Repositories\BaseRepository;
use Modules\Translation\Entities\TranslationTranslation;

interface TranslationRepository extends BaseRepository
{
    /**
     * @param  string  $key
     * @param  string  $locale
     * @return string
     */
  public function findByKeyAndLocale(string $key, string $locale = null): string;

    /**
     * @return mixed
     */
    public function allFormatted();

    /**
     * @return mixed
     */
    public function saveTranslationForLocaleAndKey($locale, $key, $value);

    /**
     * @return mixed
     */
    public function findTranslationByKey($key);

    /**
     * Update the given translation key with the given data
     *
     * @param  string  $key
     * @return mixed
     */
    public function updateFromImport(string $key, array $data);

    /**
     * Set the given value on the given TranslationTranslation
     *
     * @param  string  $value
     * @return void
     */
    public function updateTranslationToValue(TranslationTranslation $translationTranslation,  string $value): void;

    public function getTranslationsForGroupAndNamespace($locale, $group, $namespace);

    public function deleteBy($criteria, $params = false);
}
