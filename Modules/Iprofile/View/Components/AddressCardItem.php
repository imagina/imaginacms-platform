<?php

namespace Modules\Iprofile\View\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

class AddressCardItem extends Component
{
    public $address;

    public $addressesExtraFields;

    public function __construct($addressId = null, $address = null)
    {
        if (is_array($address) && ! empty($address)) {
            $this->address = json_decode(json_encode(array_merge(['id' => Arr::get($address, 'id', '')], $address)));
        } elseif (isset($address->id)) {
            $this->address = $address;
        } elseif (! empty($addressId)) {
            $this->address = $this->addressRepository()->getItem($addressId);
        }

        $this->addressesExtraFields = json_decode(setting('iprofile::userAddressesExtraFields', null, '[]'));
    }

    private function addressRepository()
    {
        return app('Modules\Iprofile\Repositories\AddressRepository');
    }

    public function render()
    {
        $this->user = null;

        return view('iprofile::frontend.components.address-card-item');
    }
}
