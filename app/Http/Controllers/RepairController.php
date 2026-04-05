<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairRequest;
use App\Models\Meter;
use App\Models\Repair;
use App\Services\StoreRepairService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $meters = Meter::with('villager')->get();
        return view('repairs.create' , compact('meters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairRequest $request , StoreRepairService $storeRepairService)
    {
        $repair_info = $request->validated();
        $storeRepairService->storeRepair($repair_info);
    }

    /**
     * Display the specified resource.
     */
    public function show(Repair $repair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repair $repair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        //
    }
}
