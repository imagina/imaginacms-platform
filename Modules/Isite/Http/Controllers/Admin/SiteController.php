<?php

namespace Modules\Isite\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Isite\Entities\Site;
use Modules\Isite\Http\Requests\CreateSiteRequest;
use Modules\Isite\Http\Requests\UpdateSiteRequest;
use Modules\Isite\Repositories\SiteRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SiteController extends AdminBaseController
{
    /**
     * @var SiteRepository
     */
    private $site;

    public function __construct(SiteRepository $site)
    {
        parent::__construct();

        $this->site = $site;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$sites = $this->site->all();

        return view('isite::admin.sites.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('isite::admin.sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSiteRequest $request
     * @return Response
     */
    public function store(CreateSiteRequest $request)
    {
        $this->site->create($request->all());

        return redirect()->route('admin.isite.site.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('isite::sites.title.sites')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Site $site
     * @return Response
     */
    public function edit(Site $site)
    {
        return view('isite::admin.sites.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Site $site
     * @param  UpdateSiteRequest $request
     * @return Response
     */
    public function update(Site $site, UpdateSiteRequest $request)
    {
  
      $data = $request->all();
      $token =$data['_token'];
      unset($data['_token']);
      unset($data['_method']);
      unset($data['locale']);
      
      $newData['_token']=$token;//Add token first
  
      //saving Logo Header
      $requestimage =$data['logoHeader'];
      if(($requestimage==NULL) || (!empty($requestimage)) )
        $requestimage = $this->saveImage($requestimage,"assets/isite/logoHeader.jpg");
      $newData['isite::logoHeader']=$requestimage;
  
      //saving Logo Footer
      $requestimage =$data['logoFooter'];
      if(($requestimage==NULL) || (!empty($requestimage)) )
        $requestimage = $this->saveImage($requestimage,"assets/isite/logoHeader.jpg");
      $newData['isite::logoFooter']=$requestimage;
  
      //saving Favicon
      $requestimage =$data['favicon'];
      if(($requestimage==NULL) || (!empty($requestimage)) )
        $requestimage = $this->saveImage($requestimage,"assets/isite/favicon.jpg");
      $newData['isite::favicon']=$requestimage;
    
      
      foreach ($data as $key => $val)
      $newData['isite::'.$key ]= $val;
  
      $this->setting->createOrUpdate($newData);
      return redirect()->route('admin.icommerce.payment.index')
        ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommercepaypal::paypalconfigs.single')]));
    

        return redirect()->route('admin.isite.site.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('isite::sites.title.sites')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Site $site
     * @return Response
     */
    public function destroy(Site $site)
    {
        $this->site->destroy($site);

        return redirect()->route('admin.isite.site.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('isite::sites.title.sites')]));
    }
}
