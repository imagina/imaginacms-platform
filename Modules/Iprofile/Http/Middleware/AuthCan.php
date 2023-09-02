<?php

namespace Modules\Iprofile\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\UserInterface;
use Modules\User\Repositories\UserTokenRepository;

class AuthCan extends BaseApiController
{
    /**
     * @var UserTokenRepository
     */
    private $userToken;

    /**
     * @var Authentication
     */
    protected $auth;

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

        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        if (! isset($params->permissions[$permission]) || $params->permissions[$permission] === false) {
            return response('Unauthorized.', 403);
        }

        return $next($request);
    }

      private function getUserFromToken(string $token): UserInterface
      {
          $found = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

          // imagina patch: add validate with passport token
          if ($found === null) {
            //$id = (new Parser())->parse($this->parseToken($token))->getClaim('aud' );
              $user = auth('api')->user(); //$this->passportToken->find($id);
              if ($user === null) {
                  return false;
              }
          } else {
              $user = $found->user;
          }

          return $user;
      }

    private function parseToken(string $token): string
    {
        return str_replace('Bearer ', '', $token);
    }
}
