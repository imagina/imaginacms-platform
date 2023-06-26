<?php

namespace Modules\Media\Helpers;

use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Get first token of string before delimiter
     */
    public static function getTypeByMimetype($mimetype): string
    {
        return strtok($mimetype, '/');
    }

    /**
     * Get Font Awesome icon for various files
     */
    public static function getFaIcon(string $mediaType): string
    {
        switch ($mediaType) {
            case 'video':
                return 'fa-file-video-o';
            case 'audio':
                return 'fa-file-audio-o';
            default:
                return 'fa-file';
        }
    }

    public static function slug($name)
    {
        $extension = self::getExtension($name);
        $name = str_replace($extension, '', $name);

        $name = Str::slug($name);

        return $name.strtolower($extension);
    }

    /**
     * Get the extension from the given name
     */
    public static function getExtension($name): string
    {
        return substr($name, strrpos($name, '.'));
    }
}
