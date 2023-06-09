<?php

namespace Modules\User\Repositories\Sentinel;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserHasActivatedAccount;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class SentinelAuthentication implements Authentication
{
    /**
     * Authenticate a user
     *
     * @param  bool  $remember    Remember the user
     * @return mixed
     */
    public function login(array $credentials, bool $remember = false)
    {
        try {
            if (Sentinel::authenticate($credentials, $remember)) {
                return false;
            }

            return trans('user::users.invalid login or password');
        } catch (NotActivatedException $e) {
            return trans('user::users.account not validated');
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();

            return trans('user::users.account is blocked', ['delay' => $delay]);
        }
    }

    /**
     * Register a new user.
     */
    public function register(array $user): bool
    {
        return Sentinel::getUserRepository()->create((array) $user);
    }

    /**
     * Assign a role to the given user.
     *
     * @return mixed
     */
    public function assignRole(UserRepository $user, RoleRepository $role)
    {
        return $role->users()->attach($user);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(): bool
    {
        return Sentinel::logout();
    }

    /**
     * Activate the given used id
     *
     * @return mixed
     */
    public function activate(int $userId, string $code)
    {
        $user = Sentinel::findById($userId);

        $success = Activation::complete($user, $code);
        if ($success) {
            event(new UserHasActivatedAccount($user));
        }

        return $success;
    }

    /**
     * Create an activation code for the given user
     *
     * @return mixed
     */
    public function createActivation(UserRepository $user)
    {
        return Activation::create($user)->code;
    }

    /**
     * Create a reminders code for the given user
     *
     * @return mixed
     */
    public function createReminderCode(UserRepository $user)
    {
        $reminder = Reminder::exists($user) ?: Reminder::create($user);

        return $reminder->code;
    }

    /**
     * Completes the reset password process
     */
    public function completeResetPassword($user, string $code, string $password): bool
    {
        return Reminder::complete($user, $code, $password);
    }

    /**
     * Determines if the current user has access to given permission
     */
    public function hasAccess($permission): bool
    {
        if (! Sentinel::check()) {
            return false;
        }

        return Sentinel::hasAccess($permission);
    }

    /**
     * Check if the user is logged in
     */
    public function check(): bool
    {
        $user = Sentinel::check();

        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * Get the currently logged in user
     */
    public function user(): \Modules\User\Entities\UserInterface
    {
        return Sentinel::getUser();
    }

    /**
     * Get the ID for the currently authenticated user
     */
    public function id(): int
    {
        $user = $this->user();

        if ($user === false) {
            return 0;
        }

        return $user->id;
    }

    public function logUserIn(UserInterface $user): UserInterface
    {
        return Sentinel::login($user);
    }
}
