<?php

namespace App\Http\Controllers;

use App\Services\AdminStatisticsDashboardService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdminStatisticsDashboardService $statsService)
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
    public function create()
    {
        //
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
