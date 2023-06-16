<?php

namespace Modules\User\Services;

use Illuminate\Support\Arr;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Exceptions\InvalidOrExpiredResetCode;
use Modules\User\Exceptions\UserNotFoundException;
use Modules\User\Repositories\UserRepository;

class UserResetter
{
    /**
     * @var UserRepository
     */
    private $user;

    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(UserRepository $user, Authentication $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    /**
     * Start the reset password process for given credentials (email)
     *
     * @throws UserNotFoundException
     */
    public function startReset(array $credentials)
    {
        $user = $this->findUser($credentials);

        $code = $this->auth->createReminderCode($user);

        event(new UserHasBegunResetProcess($user, $code));
    }

    /**
     * Finish the reset process
     *
     * @return mixed
     *
     * @throws InvalidOrExpiredResetCode
     * @throws UserNotFoundException
     */
    public function finishReset(array $data)
    {
        $user = $this->user->find(Arr::get($data, 'userId'));

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $code = Arr::get($data, 'code');
        $password = Arr::get($data, 'password');
        if (! $this->auth->completeResetPassword($user, $code, $password)) {
            throw new InvalidOrExpiredResetCode();
        }

        return $user;
    }

    /**
     * @return mixed
     *
     * @throws UserNotFoundException
     */
    private function findUser(array $credentials)
    {
        $user = $this->user->findByCredentials((array) $credentials);
        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
