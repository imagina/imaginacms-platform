<?php

namespace Modules\Ibanners\Services;

use Modules\Ibanners\Repositories\BannerRepository;

class BannerOrderer
{
    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    public function __construct(BannerRepository $banner)
    {
        $this->bannerRepository = $banner;
    }

    public function handle($data)
    {
        $data = $this->convertToArray(json_decode($data));

        foreach ($data as $order => $item) {
            $this->order($order, $item);
        }
    }

    /**
     * Order recursively the bannerr items
     */
    private function order($order, array $item)
    {
        $banner = $this->bannerRepository->find($item['id']);
        $this->saveOrder($banner, $order);
    }

    /**
     * Save the given order on the bannerr item
     */
    private function saveOrder(object $banner, int $order)
    {
        $this->bannerRepository->update($banner, ['order' => $order]);
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
