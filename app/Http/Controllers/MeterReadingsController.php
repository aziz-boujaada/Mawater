<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeterReadings;
use App\Models\Meter;
use App\Models\MeterReadings;
use App\Services\ListingQueryService;
use App\Services\StoreReadingService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeterReadingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index(Request $request)
    {
        $user = Auth::user();
        $query = MeterReadings::with('meter.villager.user');

        if ($user->role == 'villager') {
            $villagerId = $user->villager?->id;

            $query->whereHas('meter.villager', function ($listingQuery) use ($villagerId) {
                $listingQuery->where('villager_id', $villagerId);
            });
        }

        ListingQueryService::apply($query, $request, [
            'search' => ['reading_date'],
            'relations' => [
                'meter' => ['meter_reference'],
                'meter.villager.user' => ['name', 'email', 'phone'],
            ],
            'date_field' => 'reading_date',
        ]);

        $readings = $query->orderByDesc('reading_date')->paginate(10)->withQueryString();
        return view('dashboards.readings.index', compact('readings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public static function create(Request $request)
    {
        $meter_of = Meter::with('villager')->get();

        return view('dashboards.readings.create', compact('meter_of'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeterReadings $request , StoreReadingService $storeReadingService)
    {

        $user_role = Auth::user()->role;
        try {
            $reading_data = $request->validated();
            $storeReadingService->storeReading($reading_data);
            if ($user_role == 'collector') {
                return redirect()->route('dashboard.collector')->with('success', "Reading created with success");
            }

            return redirect()->route('readings')->with('success', "Reading created with success");
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
   public function show(MeterReadings $reading)
{
    $reading->load(['meter.villager.user']);

    return view('dashboards.readings.show', compact('reading'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeterReadings $meterReadings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeterReadings $meterReadings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeterReadings $meterReadings)
    {
        //
    }
}
