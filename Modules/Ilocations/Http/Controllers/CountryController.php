<?php

namespace Modules\Ilocations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Http\Controllers\BasePublicController;

class CountryController extends BasePublicController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('ilocations::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('ilocations::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('ilocations::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('ilocations::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
        public function charge_countries()
    {
        $path = public_path('/assets/ilocations/countries.json');
        
        $countries = json_decode(file_get_contents($path), true);
        dd($countries);
        foreach ($countries as $key => $country) {
            dd($country);
        }
        return $countries;
    }
}
