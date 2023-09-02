<?php

namespace Modules\Media\Image;

class Thumbnail
{
    /**
     * @var array
     */
    private $filters;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $format;

    private function __construct($name, $filters, $format = 'jpg')
    {
        $this->filters = $filters;
        $this->name = $name;
        $this->format = $format;
    }

    public static function make($thumbnailDefinition, $format = 'jpg'): static
    {
        $name = key($thumbnailDefinition);

        return new static($name, $thumbnailDefinition[$name], $format);
    }

    /**
     * Make multiple thumbnail classes with the given array
     */
    public static function makeMultiple(array $thumbnailDefinitions): array
    {
        $thumbnails = [];

        foreach ($thumbnailDefinitions as $name => $thumbnail) {
            $thumbnails[] = self::make([$name => $thumbnail]);
        }

        return $thumbnails;
    }

    /**
     * Return the thumbnail name
     */
    public function name(): string
    {
        return $this->name;
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function format(): string
    {
        return $this->format;
    }

    /**
     * Return the first width option found in the filters
     */
    public function width(): int
    {
        return $this->getFirst('width');
    }

    /**
     * Return the first height option found in the filters
     */
    public function height(): int
    {
        return $this->getFirst('height');
    }

    /**
     * Get the thumbnail size in format: width x height
     */
    public function size(): string
    {
        return $this->width().'x'.$this->height();
    }

    /**
     * Get the first found key in filters
     */
    private function getFirst(string $key): int
    {
        foreach ($this->filters as $filter) {
            if (isset($filter[$key])) {
                return (int) $filter[$key];
            }
        }
    }
}
