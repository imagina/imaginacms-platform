<?php

namespace Modules\User\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Contracts\Authentication;
use Modules\User\Entities\UserInterface;
use Modules\User\Repositories\UserTokenRepository;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser;

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

    /**
     * @param Request $request
     * @param \Closure $next
     * @param string $permission
     * @return Response
     */
    public function handle(Request $request, \Closure $next, $permission)
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

    /**
     * @param string $token
     * @return UserInterface
     */
    private function getUserFromToken($token)
    {
        $token = $this->userToken->findByAttributes(['access_token' => $this->parseToken($token)]);

      // imagina patch: add validate with passport token
      if($token === null){
        $id = (new Parser())->parse($this->parseToken($token))->getHeader('jti');
        $token = $this->passportToken->find($id);
        if ($token === null)
          return false;
      }
      return $token->user;
    }

    /**
     * @param string $token
     * @return string
     */
    private function parseToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }
}
