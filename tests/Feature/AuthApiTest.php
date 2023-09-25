<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Modules\Iprofile\Http\Controllers\Api\AuthApiController;
use Modules\Iprofile\Http\Controllers\Api\UserApiController;
use Modules\Iprofile\Http\Controllers\Api\FieldApiController;
use Modules\Iprofile\Repositories\UserApiRepository;
use PHPUnit\Framework\Attributes\Depends;

class AuthApiTest extends TestCase
{
    /**
     * @var UserApiController
     */
    private $userApi;

    /**
     * @var FieldApiController
     */
    private $fieldApi;

    /**
     * @var UserApiRepository
     */
    private $user;

    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->userApi = app(UserApiController::class);
        $this->fieldApi = app(FieldApiController::class);
        $this->user = app(UserApiRepository::class);
    }
    
    /** @test */
    public function test_Auth_Api(): void
    {        
        $Authapi = new AuthApiController($this->userApi, $this->fieldApi, $this->user);
        $request = (object)['login'=> 'user@domain.tld', 'password'=> 'Pa$$w0rd'];
        $response = $Authapi->authAttempt($request);
        dd($response->original['data']['bearer']);
        $this->assertNotNull($response->original['data']['bearer']);
        $this->token = $response;
    }

    /** @test */
    public function test_Logout_api(): void
    {
        $this->test_Auth_Api();
        $Authapi = new AuthApiController($this->userApi, $this->fieldApi, $this->user);
        $request = $this->token;
        //dd($request->original['data']['bearer']);
        $response = $Authapi->logout($request);
        $this->assertNull($response);
    }

    /** @test */
    public function test_Clear_token(): void
    {
        $this->test_Auth_Api();
        $Authapi = new AuthApiController($this->userApi, $this->fieldApi, $this->user);
        //$request = $this->token;
        //dd($request->original['data']['bearer']);
        $response = $Authapi->clearTokens();
        $this->assertNotNull($response);        
    }

}
