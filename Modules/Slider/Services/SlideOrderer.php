<?php

namespace Modules\Slider\Services;

use Modules\Slider\Repositories\SlideRepository;

class SlideOrderer
{
    /**
     * @var SlideRepository
     */
    private $slideRepository;

    public function __construct(SlideRepository $slide)
    {
        $this->slideRepository = $slide;
    }

    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $position => $item) {
            $this->order($position, $item);
        }
    }

    /**
     * Order recursively the slider items
     */
    private function order(int $position, array $item)
    {
        $slide = $this->slideRepository->find($item['id']);
        $this->savePosition($slide, $position);
    }

    /**
     * Save the given position on the slider item
     */
    private function savePosition(object $slide, int $position)
    {
        $this->slideRepository->update($slide, ['position' => $position]);
    }

    /**
     * Convert the object to array
     */
    private function convertToArray($data): array
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
