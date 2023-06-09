<?php

namespace Modules\Ifollow\Http\Livewire;

use Livewire\Component;

class Followers extends Component
{
    public $followableId;

    public $followableType;

    public $totalFollowers;

    public $followerLabel;

    protected $listeners = ['updateFollowers' => 'getFollowers'];

    public function mount($followableId, $followableType)
    {
        $this->followableId = $followableId;
        $this->followableType = $followableType;
        $this->getFollowers();
    }

    public function getFollowers()
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

        $this->followerLabel = 'Seguidor'.($this->totalFollowers == 1 ? '' : 'es');
    }

    /*
    * Render
    * return view
    */
    public function render()
    {
        $view = 'ifollow::frontend.livewire.followersCount';

        return view($view);
    }
}
