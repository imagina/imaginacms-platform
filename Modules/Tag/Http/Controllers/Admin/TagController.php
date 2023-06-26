<?php

namespace Modules\Tag\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Tag\Entities\Tag;
use Modules\Tag\Http\Requests\CreateTagRequest;
use Modules\Tag\Http\Requests\UpdateTagRequest;
use Modules\Tag\Repositories\TagManager;
use Modules\Tag\Repositories\TagRepository;

class TagController extends AdminBaseController
{
    /**
     * @var TagRepository
     */
    private $tag;

    /**
     * @var TagManager
     */
    private $tagManager;

    public function __construct(TagRepository $tag, TagManager $tagManager)
    {
        parent::__construct();

        $this->tag = $tag;
        $this->tagManager = $tagManager;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $tags = $this->tag->all();

        return view('tag::admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $namespaces = $this->formatNamespaces($this->tagManager->getNamespaces());

        return view('tag::admin.tags.create', compact('namespaces'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTagRequest $request): Response
    {
        $this->tag->create($request->all());

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('tag::tags.tags')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag): Response
    {
        $namespaces = $this->formatNamespaces($this->tagManager->getNamespaces());

        return view('tag::admin.tags.edit', compact('tag', 'namespaces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Tag $tag, UpdateTagRequest $request): Response
    {
        $this->tag->update($tag, $request->all());

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('tag::tags.tags')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag): Response
    {
        $this->tag->destroy($tag);

        return redirect()->route('admin.tag.tag.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('tag::tags.tags')]));
    }

    private function formatNamespaces(array $namespaces)
    {
        $new = [];
        foreach ($namespaces as $namespace) {
            $new[$namespace] = $namespace;
        }

        return $new;
    }
}
