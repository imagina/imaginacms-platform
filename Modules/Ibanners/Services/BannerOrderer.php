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
     *
     * @param  array  $item
     */
    private function order($order, $item)
    {
        $banner = $this->bannerRepository->find($item['id']);
        $this->saveOrder($banner, $order);
    }

    /**
     * Save the given order on the bannerr item
     *
     * @param  object  $banner
     * @param  int  $order
     */
    private function saveOrder($banner, $order)
    {
        $this->bannerRepository->update($banner, ['order' => $order]);
    }

    /**
     * Convert the object to array
     *
     * @return array
     */
    private function convertToArray($data)
    {
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}
