<?php

namespace Modules\Ifollow\Http\Livewire;

use http\Params;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Follow extends Component
{
    /**
     * Attributes
     */
    public $isLogged;
    public $isFollowing;
    public $followableType;
    public $followableId;
    public $followerId;
    public $needRedirectToLogin;


    /*
    * Runs once, immediately after the component is instantiated,
    * but before render() is called
    */
    public function mount($followableId, $followableType)
    {

        $this->isFollowing = false;
        $this->needRedirectToLogin = false;
        $this->followableId = $followableId;
        $this->followableType = $followableType;
        $this->identityFollow();
        $this->isFollowing();
    }



    //user loguin
    public function identityFollow()
    {
        $this->needRedirectToLogin = false;
        $user = Auth::user();

        //if isset an user authenticated
        $this->followerId = $user->id ?? null;

        if (empty($this->followerId)) $this->needRedirectToLogin = true;
    }

    public function isFollowing()
    {
        $repository = app("Modules\Ifollow\Repositories\FollowerRepository");
        $params = [
            "filter" => [
                "field" => "followable_id",
                "followableType" => $this->followableType,
                "followerId" => $this->followerId
            ]
        ];
        $follower = $repository->getItem($this->followableId, json_decode(json_encode($params)));
        //  $this->identityFollow();

        if (isset($follower->id)) {
            $this->isFollowing = true;
        } else {
            $this->isFollowing = false;
        }

    }


    //create following
    public function setNewFollower()
    {
        $this->identityFollow();
        if($this->needRedirectToLogin) return redirect()->to('/auth/login');

        $repository = app("Modules\Ifollow\Repositories\FollowerRepository");
        $data = [
            "follower_id" => $this->followerId,
            "followable_id" => $this->followableId,
            "followable_type" => $this->followableType
        ];
        $repository->create($data);
        $this->isFollowing = true;
        $this->emit('updateFollowers');
    }


    //Delete following
    public function deleteFollower()
    {
        $this->identityFollow();
        if($this->needRedirectToLogin) return redirect()->to('/auth/login');

        $repository = app("Modules\Ifollow\Repositories\FollowerRepository");
        $params = [
            "filter" => [
                "field" => "followable_id",
                "followableType" => $this->followableType,
                "followerId" => $this->followerId
            ]
        ];
        $repository->deleteBy($this->followableId, json_decode(json_encode($params)));
        $this->isFollowing = false;
        $this->emit('updateFollowers');
    }

    /*
    * Render
    * return view
    */
    public function render()
    {
        $view = 'ifollow::frontend.livewire.followers';
        return view($view);
    }
}

