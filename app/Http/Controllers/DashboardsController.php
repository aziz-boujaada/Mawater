<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MeterReadings;
use App\Models\Payment;
use App\Services\AdminStatisticsDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admin(AdminStatisticsDashboardService $statsService)
    {
        $total_users = $statsService->getTotalUsers();
        $total_villagers = $statsService->getTotalVillagers();
        $subscriberd_villagers = $statsService->subscriberdVillagers();
        $unsubscriberd_villagers = $statsService->unsubscriberdVillagers();
        $activ_meters = $statsService->getTotalActiveMetrs();
        $broken_and_outService_meters = $statsService->TotaBrokenMetrs();
        $total_budget = $statsService->getTotalBudget();
        $unpaid_payment = $statsService->getTotalUnpaidBudget();
        
        return view('dashboards.admin', compact([
            'total_users',
            'total_villagers',
            'subscriberd_villagers',
            'unsubscriberd_villagers',
            'activ_meters',
            'broken_and_outService_meters',
            'total_budget',
            'unpaid_payment'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function collector()
    {
       $collectorId = Auth::id();

    $readingsCount = MeterReadings::count();
    $invoicesCount = Invoice::where('collector_id', $collectorId)->count();
    $paymentsCount = Payment::where('collector_id', $collectorId)->count();

    $totalCollected = Payment::where('collector_id', $collectorId)->sum('amount_paid');

    return view('dashboards.collector', compact(
        'readingsCount',
        'invoicesCount',
        'paymentsCount',
        'totalCollected'
    ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
