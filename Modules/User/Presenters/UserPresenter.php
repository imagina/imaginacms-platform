<?php

namespace Modules\User\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    /**
     * Return the gravatar link for the users email
     */
    public function gravatar(int $size = 90): string
    {
        $email = md5($this->email);

        return "https://www.gravatar.com/avatar/$email?s=$size";
    }

    public function fullname(): string
    {
        return $this->name ?: $this->first_name.' '.$this->last_name;
    }
}
