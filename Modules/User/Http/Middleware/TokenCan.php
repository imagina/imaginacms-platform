<?php

namespace Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\UserInterface;
use Modules\User\Repositories\UserTokenRepository;

class TokenCan
{
    /**
     * @var UserTokenRepository
     */
    private $userToken;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @var passportToken
     */
    private $passportToken;

    public function __construct(UserTokenRepository $userToken, Authentication $auth, TokenRepository $passportToken)
    {
        $this->userToken = $userToken;
        $this->auth = $auth;
        $this->passportToken = $passportToken;
    }

    public function handle(Request $request, \Closure $next, string $permission): Response
    {
        if ($request->header('Authorization') === null) {
            return new Response('Forbidden', Response::HTTP_FORBIDDEN);
        }

        $user = $this->getUserFromToken($request->header('Authorization'));

        if ($user->hasAccess($permission) === false) {
            return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    private function getUserFromToken(string $token): UserInterface
    {
        $token = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

        // imagina patch: add validate with passport token
        if ($token === null) {
            $id = (new Parser())->parse($this->parseToken($token))->getHeader('jti');
            $token = $this->passportToken->find($id);
            if ($token === null) {
                return false;
            }
        }

        return $token->user;
    }

    private function parseToken(string $token): string
    {
        return str_replace('Bearer ', '', $token);
    }
}
