<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Meter;
use App\Models\MeterReadings;
use App\Models\Payment;
use App\Models\Repair;
use App\Services\AdminStatisticsDashboardService;
use App\Services\VillagerStatisticsDashboard;
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
        $total_paid = $statsService->getTotalPaid();
        $unpaid_payment = $statsService->getTotalUnpaidBudget();
        $repairLoseAmount = $statsService->getRepairLosesAmount();
        $netProfit = $statsService->calculNetProfit();
        $profitMargin = $statsService->getProfitMargin();
        $lossPercentage = $statsService->getLossPercentage();
        $paidPercentage = $statsService->getPaidPaymentsPercentage();

        return view('dashboards.admin', compact([
            'total_users',
            'total_villagers',
            'subscriberd_villagers',
            'unsubscriberd_villagers',
            'activ_meters',
            'broken_and_outService_meters',
            'total_budget',
            'total_paid',
            'unpaid_payment',
            'repairLoseAmount',
            'netProfit',
            'profitMargin',
            'lossPercentage',
            'paidPercentage'
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

        $repairsCount = Repair::count();


        $repairsAmountLose = Repair::sum('repair_cost');

        $moyenCost = $repairsCount > 0
            ? $repairsAmountLose / $repairsCount
            : 0;

        $completedRepairs = Repair::where('status', 'repaired')->count();

        $inProgressRepairs = Repair::where('status', 'in progress')->count();

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


    public function villager(VillagerStatisticsDashboard $villagerStats)
    {
        $villager_id = Auth::user()->villager?->id;

        $meters = $villagerStats->getReadingsOfVillager($villager_id);
        $invoices = $villagerStats->getInvoicesOfVillager($villager_id);
        $payments = $villagerStats->getPaymentsOfVillager($villager_id);
        $readingsCount = $villagerStats->getTotalReadings($villager_id);
        $invoicesCount = $villagerStats->getTotalInvoices($villager_id);
        $unPaidInvoicesCount = $villagerStats->getTotalunPaidInvoices($villager_id);
        $paidInvoicesCount = $villagerStats->getTotalPaidInvoices($villager_id);
        $totalAmountPaid = $villagerStats->getPaidAmount($villager_id);
        $remainingAmount = $villagerStats->getUnpaidAmount($villager_id);

        return view('dashboards.villager', compact(
            'meters',
            'invoices',
            'payments',
            'readingsCount',
            'invoicesCount',
            'paidInvoicesCount',
            'unPaidInvoicesCount',
            'totalAmountPaid',
            'remainingAmount'
        ));
    }
}
