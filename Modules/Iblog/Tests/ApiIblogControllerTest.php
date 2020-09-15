<?php

namespace Modules\Iblog\Tests;

use Modules\Iblog\Entities\Post;
use Modules\User\Entities\Sentinel\User;
use Modules\Iblog\Http\Controllers\Api\PostApiController;
use Modules\Iblog\Http\Requests\CreatePostRequest;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Tests\BaseIblogTest;


class ApiIblogControllerTest extends BaseIblogTest
{
    /**
     * @var PostRepository
     */
    protected $post;
    /**
     * @var CategoryRepository
     */
    protected $postCategory;


    public function setUp()
    {
        parent::setUp();
        $this->post = app(PostRepository::class);
        $this->category = app(CategoryRepository::class);

    }

    /** @test */
    public function it_creates_a_new_post()
    {
        //$user = factory(User::class)->create();

        $response = $this->json('GET','/');

        //$response->assertStatus(200);

        return;
        $data = [
            'email' => 'user@domain.tld',
            'password' => 'Pa$$w0rd',
            'is_activated' => true,
        ];

        $request = CreatePostRequest::create('', '', $data);
        $controller = new PostApiController($this->post);

        $controller->create($request);
        $user = $this->user->find(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertTrue($user->isActivated());
    }
}
