<?php

namespace Modules\Ichat\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Ichat\Entities\Message;
use Modules\Ichat\Http\Requests\CreateMessageRequest;
use Modules\Ichat\Http\Requests\UpdateMessageRequest;
use Modules\Ichat\Repositories\MessageRepository;

class MessageController extends AdminBaseController
{
    /**
     * @var MessageRepository
     */
    private $message;

    public function __construct(MessageRepository $message)
    {
        parent::__construct();

        $this->message = $message;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$messages = $this->message->all();

        return view('ichat::admin.messages.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('ichat::admin.messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateMessageRequest $request)
    {
        $this->message->create($request->all());

        return redirect()->route('admin.ichat.message.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('ichat::messages.title.messages')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Message $message)
    {
        return view('ichat::admin.messages.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Message $message, UpdateMessageRequest $request)
    {
        $this->message->update($message, $request->all());

        return redirect()->route('admin.ichat.message.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('ichat::messages.title.messages')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Message $message)
    {
        $this->message->destroy($message);

        return redirect()->route('admin.ichat.message.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('ichat::messages.title.messages')]));
    }
}
