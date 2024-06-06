<?php

namespace Modules\Iblog\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Iblog\Entities\Status;
use Modules\Iblog\Entities\Post;
use Modules\Iblog\Http\Requests\CreatePostRequest;
use Modules\Iblog\Repositories\CategoryRepository;
use Modules\Iblog\Repositories\PostRepository;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;


class PostController extends AdminBaseController
{

    /**
     * @var PostRepository
     */
    private $post;
    /**
     * @var CategoryRepository
     */
    private $category;

    /**
     * @var Status
     */
    private $status;
    /**
     * @var Role
     */
    private $role;

    /**
     * @var Role
     */
    private $user;


    public function __construct(PostRepository $post, CategoryRepository $category, Status $status, RoleRepository $role, UserRepository $user)
    {
        parent::__construct();
        $this->post = $post;
        $this->category = $category;
        $this->status = $status;
        $this->role = $role;
        $this->user=$user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {

        if($request->input('q')){
            $param=$request->input('q');
           $posts=$this->post->search($param);
        }else{
            $posts = $this->post->paginate(20);
        }
        return view('iblog::admin.posts.index', compact('posts'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users= $this->user->all();
        $status = $this->status->lists();
        $categories = $this->category->all();
        return view('iblog::admin.posts.create', compact('categories','status', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest $request
     * @return Response
     */
    public function store(CreatePostRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->post->create($request->all());
            \DB::commit();//Commit to Data Base
            return redirect()->route('admin.iblog.post.index')
                ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('iblog::posts.title.posts')]));

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::posts.title.posts')]))->withInput($request->all());

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return Response
     */
    public function edit(Post $post)
    {
        $users= $this->user->all();
        $status = $this->status->lists();
        $categories = $this->category->all();
        return view('iblog::admin.posts.edit', compact('post', 'categories','status', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Post $Post
     * @param CreatePostRequest $request
     * @return Response
     */
    public function update(Post $post, CreatePostRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->post->update($post, $request->all());
            \DB::commit();//Commit to Data Base
            return redirect()->route('admin.iblog.post.index')
                ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('iblog::posts.title.posts')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::posts.title.posts')]))->withInput($request->all());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        try {
            $this->post->destroy($post);

            return redirect()->route('admin.iblog.post.index')
                ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('iblog::posts.title.posts')]));
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()
                ->withError(trans('core::core.messages.resource error', ['name' => trans('iblog::posts.title.posts')]));

        }
    }


}
