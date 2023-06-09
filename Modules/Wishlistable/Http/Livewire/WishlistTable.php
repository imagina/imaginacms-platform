<?php

namespace Modules\Wishlistable\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Modules\Wishlistable\Transformers\WishlistTransformer;

class WishlistTable extends Component
{
    public $moduleView;

    public $wishlist;

    private $params;

    public function mount(Request $request, $showButton = false)
    {
        $this->moduleView = 'wishlistable::frontend.livewire.wishlistable';
        $this->showButton = $showButton;
        $this->quantity = null;

        $this->getWishListUser();
    }

    public function wishlistRepository(): wislistRepository
    {
        return app('Modules\Wishlistable\Repositories\WishlistableRepository');
    }

    public function wishlistEntity(): wishListEntity
    {
        return app('Modules\Wishlistable\Entities\Wishlistable');
    }

    /**
     * Render wishlist
     */
    public function render()
    {
        return view($this->moduleView);
    }

    /**
     *  Add product to wishlist
     */
    public function addToWishList($data)
    {
        $user = \Auth::user(); //Get user
        //Validate session
        if (! $user) {
            $this->alert('warning', trans('wishlistable::wishlistables.messages.unauthenticated'), [
                'position' => 'top-end',
                'iconColor' => setting('isite::brandPrimary', '#fff'),
            ]);
        } else {
            //Create or update product
            $this->wishlistEntity()->updateOrCreate(
                ['user_id' => $user->id, 'wishlistable_type' => $data['entityName'], 'wishlistable_id' => $data['entityId']]
            );
            $this->initQuantity();
            //Message
            $this->alert('success', trans('wishlistable::wishlistables.messages.itemAdded'), config('asgard.isite.config.livewireAlerts'));
        }
    }

    /**
     *  Add product to wishlist
     */
    public function deleteFromWishlist($id)
    {
        $user = \Auth::user(); //Get user
        //Validate session
        if (! $user) {
            $this->alert('warning', trans('wishlistable::wishlistables.messages.unauthenticated'), [
                'position' => 'top-end',
                'iconColor' => setting('isite::brandPrimary', '#fff'),
            ]);
        } else {
            //Create or update product
            $item = $this->wishlistEntity()->find($id);

            if (isset($item->id)) {
                $item->delete();

                $this->getWishListUser();
                //Message
                $this->alert('success', trans('wishlistable::wishlistables.messages.itemDeleted'), config('asgard.isite.config.livewireAlerts'));
            }
        }
    }

    /**
     * Get user wishlist
     */
    public function getWishListUser($userId = null)
    {
        if (is_null($userId)) {
            $userId = \Auth::id();
        }
        $params = json_decode(json_encode([
            'filter' => [
                'user' => $userId,
            ],
        ]));
        $this->wishlist = json_decode(json_encode(WishlistTransformer::collection($this->wishlistRepository()->getItemsBy($params))));
    }
}
