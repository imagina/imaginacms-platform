<?php

namespace Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser;
use Modules\User\Contracts\Authentication;
use Modules\User\Repositories\UserTokenRepository;

class AuthorisedApiToken
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

    public function handle(Request $request, \Closure $next)
    {
        if ($request->header('Authorization') === null) {
            return new Response('Forbidden', 403);
        }

        if ($this->isValidToken($request->header('Authorization')) === false) {
            return new Response('Forbidden', 403);
        }

        return $next($request);
    }

    private function isValidToken($token)
    {
        $found = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

        if ($found === null) {
            // Imagina Patch: Add validation with passport token
            //$id = (new Parser())->parse($this->parseToken($token))->getHeader('jti');
            $user = auth('api')->user(); //$this->passportToken->find($id);
            if ($user === null) {
                return false;
            }
        } else {
            $user = $found->user;
        }

        $this->auth->logUserIn($user);

        return true;
    }

    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
