<?php

namespace Modules\Wishlistable\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class Wishlist extends Component
{

 
  public $moduleView;
  public $showButton;
  public $quantity;

  private $params;
  protected $listeners = ['addToWishList','deleteFromWishlist','initWishlistQuantity' => "initQuantity"];

  public function mount(Request $request, $showButton = false)
  {
    $this->moduleView = 'wishlistable::frontend.livewire.wishlist';
    $this->showButton = $showButton;
    $this->quantity = null;
    
    $this->initQuantity();
  }

  
  public function initQuantity(){
    $user = \Auth::user();
    
    if(isset($user->id))
      $this->quantity = $this->wishlistEntity()->where("user_id",$user->id)->get()->count();
  }
  /**
   * @return wislistRepository
   */
  public function wishlistRepository()
  {
    return app('Modules\Wishlistable\Repositories\WishlistableRepository');
  }

  /**
   * @return wishListEntity
   */
  public function wishlistEntity()
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
    $user = \Auth::user();//Get user
    //Validate session
    if (!$user) {
      $this->alert('warning', trans('wishlistable::wishlistables.messages.unauthenticated'), [
        'position' => 'top-end',
        'iconColor' => setting("isite::brandPrimary", "#fff")
      ]);
    } else {
      //Create or update product
      $this->wishlistEntity()->updateOrCreate(
        ['user_id' => $user->id, 'wishlistable_type' => $data["entityName"], 'wishlistable_id' => $data["entityId"]]
      );
      $this->initQuantity();
      //Message
      $this->alert('success', trans('wishlistable::wishlistables.messages.itemAdded'), config("asgard.isite.config.livewireAlerts"));
    }
  }

  /**
   *  Add product to wishlist
   */
  public function deleteFromWishlist($id)
  {
    $user = \Auth::user();//Get user
    //Validate session
    if (!$user) {
      $this->alert('warning', trans('wishlistable::wishlistables.messages.unauthenticated'), [
        'position' => 'top-end',
        'iconColor' => setting("isite::brandPrimary", "#fff")
      ]);
    } else {
      //Create or update product
      $item = $this->wishlistEntity()->find($id);
      
      if(isset($item->id)){
        $item->delete();
        $this->initQuantity();
  
        //Message
        $this->alert('success', trans('wishlistable::wishlistables.messages.itemDeleted'), config("asgard.isite.config.livewireAlerts"));
      }
      
    }
  }

  /**
   * Get user wishlist
   */
  public function getWishListUser($userId)
  {
    $params = json_decode(json_encode([
      "filter" => [
        'user' => $userId
      ]
    ]));
    $wishlist = $this->wishlistRepository()->getItemsBy($params);

    return $wishlist;
  }
}
