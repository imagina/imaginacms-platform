<?php

namespace Modules\Ifollow\View\Components;

use Illuminate\View\Component;

class Followers extends Component
{
    private $followableId;

    private $followableType;

    public $totalFollowers;

    public $followerLabel;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($followableId, $followableType)
    {
        $this->followableId = $followableId;
        $this->followableType = $followableType;

        $this->getFollowers();
    }

     private function getFollowers()
     {
         $repository = app("Modules\Ifollow\Repositories\FollowerRepository");

         $params = [
             'filter' => [
                 'followableId' => $this->followableId,
                 'followableType' => $this->followableType,
             ],
         ];

         $followers = $repository->getItemsBy(json_decode(json_encode($params)));

         $this->totalFollowers = $followers->count();

         $this->followerLabel = 'ifollow::followers.followers'.($this->totalFollowers == 1 ? '' : 's');
     }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ifollow::frontend.components.followers');
    }
}
