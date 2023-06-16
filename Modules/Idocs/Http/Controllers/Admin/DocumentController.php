<?php

namespace Modules\Idocs\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Idocs\Entities\Document;
use Modules\Idocs\Http\Requests\CreateDocumentRequest;
use Modules\Idocs\Http\Requests\UpdateDocumentRequest;
use Modules\Idocs\Imports\IdocsImport;
use Modules\Idocs\Repositories\CategoryRepository;
use Modules\Idocs\Repositories\DocumentRepository;
//External libraries
use Modules\User\Repositories\UserRepository;

class DocumentController extends AdminBaseController
{
    /**
     * @var DocumentRepository
     */
    private $document;

    private $category;

    /**
     * @var User
     */
    private $user;

    public function __construct(DocumentRepository $document, CategoryRepository $category, UserRepository $user)
    {
        parent::__construct();

        $this->document = $document;
        $this->category = $category;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->input('q')) {
            $param = $request->input('q');
            $documents = $this->document->search($param);
        } else {
            $documents = $this->document->paginate(20);
        }

        return view('idocs::admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->category->all();
        $users = $this->user->all();

        return view('idocs::admin.documents.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateDocumentRequest $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->all();
            $data['key'] = str_random(30);

            $this->document->create($data);
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.document.index')
                ->withSuccess(trans('idocs::common.messages.resource created', ['name' => trans('idocs::documents.title.documents')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(Document $document)
    {
        $categories = $this->category->all();
        $users = $this->user->all();

        return view('idocs::admin.documents.edit', compact('document', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Document $document, UpdateDocumentRequest $request)
    {
        \DB::beginTransaction();
        try {
            $this->document->update($document, $request->all());
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.document.index')
                ->withSuccess(trans('idocs::common.messages.resource updated', ['name' => trans('idocs::documents.title.documents')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]))->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy(Document $document)
    {
        \DB::beginTransaction();
        try {
            $this->document->destroy($document);
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.document.index')
                ->withSuccess(trans('idocs::common.messages.resource deleted', ['name' => trans('idocs::documents.title.documents')]));
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function migration()
    {
        $locale = \LaravelLocalization::getSupportedLocales();

        return view('idocs::admin.documents.migration', compact('locale'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function import(Request $request)
    {
        \DB::beginTransaction();
        try {
            dd($request->file);
            $data = $request->all();
            $user = \Auth::user();
            $data = ['user_id' => $user->id, 'Locale' => \LaravelLocalization::setLocale() ?: \App::getLocale()];
            $data_excel = Excel::import(new IdocsImport($this->document, $data), $request->file);

            dd($data_excel);
            \DB::commit(); //Commit to Data Base

            return redirect()->route('admin.idocs.document.index')
                ->withSuccess(trans('idocs::common.messages.resource created', ['name' => trans('idocs::documents.title.documents')]));
        } catch (\Exception $e) {
            dd($e);
            \DB::rollback();
            \Log::error($e->getMessage());

            return redirect()->back()
                ->withError(trans('idocs::common.messages.resource error', ['name' => trans('idocs:categories.title.categories')]))->withInput($request->all());
        }
    }
}
