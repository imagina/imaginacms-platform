<?php

namespace Modules\Media\Validators;

use FilesystemIterator;
use Illuminate\Contracts\Validation\Rule;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MaxFolderSizeRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes(string $attribute, UploadedFile $value): bool
    {
        //check if the tenant its initialized and the folder size must be calculated of the organization folder
        $tenantPrefix = mediaOrganizationPrefix(null, '/');
        $mediaPath = public_path(($tenantPrefix).config('asgard.media.config.files-path'));

        $activateCheckOfDirSize = json_decode(setting('media::activateCheckOfDirSize', null, '1'));

        $folderSize = $activateCheckOfDirSize ? $this->getDirSize($mediaPath) : '0';

        preg_match('/([0-9]+)/', $folderSize, $match);

        return ($match[0] + $value->getSize()) < setting('media::maxTotalSize', null, config('asgard.media.config.max-total-size'));
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        $bytes = setting('media::maxTotalSize', null, config('asgard.media.config.max-total-size'));
        $size = $this->formatBytes($bytes);

        return trans('media::media.validation.max_size', ['size' => $size]);
    }

    /**
     * Get the directory size
     */
    public function getDirSize(string $directory): int
    {
        $size = 0;

        //adding this try catch to avoid the error 500 when the path don't exist
        try {
            foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {
                $size += $file->getSize();
            }
        } catch(\Exception $e) {
            \Log::info('Media::MaxFolderSizeRule | Error getting Dir Size: '.$e->getMessage());
        }

        return $size;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = [
            trans('media::media.file-sizes.B'),
            trans('media::media.file-sizes.KB'),
            trans('media::media.file-sizes.MB'),
            trans('media::media.file-sizes.GB'),
            trans('media::media.file-sizes.TB'),
        ];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision).' '.$units[$pow];
    }
}
