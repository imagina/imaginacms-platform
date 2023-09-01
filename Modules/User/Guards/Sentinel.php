<?php

namespace Modules\User\Guards;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel as SentinelFacade;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as LaravelGuard;

class Sentinel implements LaravelGuard
{
    /**
     * Determine if the current user is authenticated.
     */
    public function check(): bool
    {
        if (SentinelFacade::check()) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the current user is a guest.
     */
    public function guest(): bool
    {
        return SentinelFacade::guest();
    }

    /**
     * Get the currently authenticated user.
     */
    public function user(): ?Authenticatable
    {
        return SentinelFacade::getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     */
    public function id(): ?int
    {
        if ($user = SentinelFacade::check()) {
            return $user->id;
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     */
    public function validate(array $credentials = []): bool
    {
        return SentinelFacade::validForCreation($credentials);
    }

    /**
     * Determine if the guard has a user instance.
     */
    public function hasUser()
    {
        return SentinelFacade::hasUser();
    }

    /**
     * Set the current user.
     */
    public function setUser(Authenticatable $user): bool
    {
        return SentinelFacade::login($user);
    }

    /**
     * Alias to set the current user.
     */
    public function login(Authenticatable $user): bool
    {
        return $this->setUser($user);
    }

    public function attempt(array $credentials, bool $remember = false): bool
    {
        return SentinelFacade::authenticate($credentials, $remember);
    }

    public function logout(): bool
    {
        return SentinelFacade::logout();
    }

    public function loginUsingId(int $userId): bool
    {
        $user = app(\Modules\User\Repositories\UserRepository::class)->find($userId);

        return $this->login($user);
    }
}
