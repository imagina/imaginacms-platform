<?php

namespace Modules\Ilocations\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\BasePublicController;

class CountryController extends BasePublicController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ilocations::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ilocations::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     */
    public function show()
    {
        return view('ilocations::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('ilocations::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
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
