<?php

namespace Modules\Translation\Services;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Modules\Translation\ValueObjects\TranslationGroup;

class TranslationsWriter
{
    /**
     * @var Filesystem
     */
    private $finder;

    /**
     * @var TranslationsService
     */
    private $translationsService;

    public function __construct(TranslationsService $translationsService, Filesystem $finder)
    {
        $this->finder = $finder;
        $this->translationsService = $translationsService;
    }

    /**
     * Export all translations back to disk
     */
    public function export()
    {
        $translations = $this->translationsService->getFileAndDatabaseMergedTranslations();

        $tree = $this->makeTree($translations);

        foreach ($tree as $locale => $groups) {
            foreach ($groups as $moduleName => $fileGroup) {
                foreach ($fileGroup as $file => $data) {
                    $path = $this->getTranslationsDirectory().$moduleName.'/'.$locale.'/'.$file.'.php';
                    $output = "<?php\n\nreturn ".var_export($data, true).";\n";
                    $this->finder->put($path, $output);
                }
            }
        }
    }

    /**
     * Get the module name from the given key
     *
     * @param  string  $key
     * @return string
     */
    private function getModuleNameFrom(string $key): string
    {
        return substr($key, 0, strpos($key, '::'));
    }

    /**
     * @return string
     */
    private function getTranslationsDirectory(): string
    {
        return __DIR__.'/../Resources/lang/';
    }

    /**
     * Get the file name from the given key
     *
     * @param  string  $key
     * @return string
     */
    private function getFileNameFrom(string $key): string
    {
        $key = str_replace($this->getModuleNameFrom($key).'::', '', $key);

        return substr($key, 0, strpos($key, '.'));
    }

    /**
     * Make a usable array
     *
     * @return array
     */
    private function makeTree(TranslationGroup $translations): array
    {
        $tree = [];

        foreach ($translations->allRaw() as $locale => $translation) {
            foreach ($translation as $key => $trans) {
                $moduleName = $this->getModuleNameFrom($key);
                $fileName = $this->getFileNameFrom($key);
                $key = str_replace($moduleName.'::'.$fileName.'.', '', $key);

                Arr::set($tree[$locale][$moduleName][$fileName], $key, $trans);
            }
        }

        return $tree;
    }
}
