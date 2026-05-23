<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRepairRequest;
use App\Models\Meter;
use App\Models\Repair;
use App\Services\ListingQueryService;
use App\Services\StoreRepairService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $repairsQuery = Repair::with('meter.villager.user', 'repair_agent');

        ListingQueryService::apply($repairsQuery, $request, [
            'search' => ['problem_description'],
            'relations' => [
                'meter' => ['meter_reference'],
                'meter.villager.user' => ['name', 'email', 'phone'],
                'repair_agent' => ['name', 'email', 'phone'],
            ],
            'exact' => [
                'status' => 'status',
            ],
            'date_field' => 'repair_date',
            'amount_field' => 'repair_cost',
        ]);

        $repairs = $repairsQuery->orderByDesc('repair_date')->paginate(10)->withQueryString();
        return view('dashboards.repairs.index' , compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $meters = Meter::with('villager')->get();
        return view('dashboards.repairs.create' , compact('meters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRepairRequest $request , StoreRepairService $storeRepairService)
    {
        $repair_info = $request->validated();
        $storeRepairService->storeRepair($repair_info);

        return redirect()->route('repairs');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $repair = Repair::with(['meter.villager.user', 'repair_agent'])->findOrFail($id);
        return view('dashboards.repairs.show', compact('repair'));
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
