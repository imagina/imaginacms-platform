<?php

namespace Modules\Translation\ValueObjects;

use Illuminate\Support\Collection;

class TranslationGroup
{
    /**
     * @var array
     */
    private $translations;

    public function __construct(array $translations)
    {
        $this->translations = $translations;
    }

    private function reArrangeTranslations(array $translationsRaw): Collection
    {
        $translations = [];

        foreach ($translationsRaw as $locale => $translationGroup) {
            foreach ($translationGroup as $key => $translation) {
                $translations[$key][$locale] = $translation;
            }
        }

        return new Collection($translations);
    }

    /**
     * Return the translations
     */
    public function all(): Collection
    {
        return $this->reArrangeTranslations($this->translations);
    }

    /**
     * Return the raw translations
     */
    public function allRaw(): array
    {
        return $this->translations;
    }
}
