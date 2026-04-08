<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeterRequest;
use App\Models\Meter;
use App\Models\User;
use App\Models\Villager;
use App\Services\StoreMeterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $meters = Meter::with('villager')->paginate(10);
       return view('dashboards.meters.index' , compact('meters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $villagers = Villager::all();
         return  view('dashboards.meters.create' , compact('villagers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeterRequest $request)
    {
        $meterData = $request->validated();
        $meter = StoreMeterService::storeMeter($meterData);

        return redirect()->route('dashboard.admin')->with('success' , "Meter with refernce {$meter->reference} created with success");
    }

    /**
     * Display the specified resource.
     */
    public function show(Meter $meters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meter $meters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meter $meter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meter $meter)
    {
        //
    }
}
