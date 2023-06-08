<?php

namespace Modules\Ievent\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ievent\Entities\Comment;
use Modules\Ievent\Http\Requests\CreateCommentRequest;
use Modules\Ievent\Http\Requests\UpdateCommentRequest;
use Modules\Ievent\Repositories\CommentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CommentController extends AdminBaseController
{
    /**
     * @var CommentRepository
     */
    private $comment;

    public function __construct(CommentRepository $comment)
    {
        parent::__construct();

        $this->comment = $comment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$comments = $this->comment->all();

        return view('ievent::admin.comments.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ievent::admin.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCommentRequest $request
     * @return Response
     */
    public function store(CreateCommentRequest $request)
    {
        $this->comment->create($request->all());

        return redirect()->route('admin.ievent.comment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ievent::comments.title.comments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment $comment
     * @return Response
     */
    public function edit(Comment $comment)
    {
        return view('ievent::admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Comment $comment
     * @param  UpdateCommentRequest $request
     * @return Response
     */
    public function update(Comment $comment, UpdateCommentRequest $request)
    {
        $this->comment->update($comment, $request->all());

        return redirect()->route('admin.ievent.comment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ievent::comments.title.comments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment $comment
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        $this->comment->destroy($comment);

        return redirect()->route('admin.ievent.comment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ievent::comments.title.comments')]));
    }
}
