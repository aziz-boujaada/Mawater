<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MeterReadings;
use App\Models\Payment;
use App\Models\Repair;
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
    public function repair_agent()
    {
        $repairAgentId = Auth::id();

        $repairs = Repair::where('repair_agent_id', $repairAgentId);

        $repairsCount = $repairs->count();

        $repairsAmountLose = Repair::where('repair_agent_id', $repairAgentId)
            ->sum('repair_cost');

        $moyenCost = $repairsCount > 0
            ? $repairsAmountLose / $repairsCount
            : 0;

        $completedRepairs = Repair::where('repair_agent_id', $repairAgentId)
            ->where('status', 'repaired')
            ->count();

        $inProgressRepairs = Repair::where('repair_agent_id', $repairAgentId)
            ->where('status', 'in progress')
            ->count();

        $completionRate = $repairsCount > 0
            ? ($completedRepairs / $repairsCount) * 100
            : 0;

        return view('dashboards.repair_agent', compact(
            'repairsCount',
            'repairsAmountLose',
            'moyenCost',
            'completionRate',
            'completedRepairs',
            'inProgressRepairs'
        ));
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
