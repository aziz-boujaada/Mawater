<?php

namespace App\Services;

use App\Models\FinancialLose;
use App\Models\Invoice;
use App\Models\Meter;
use App\Models\Payment;
use App\Models\Repair;
use App\Models\User;
use App\Models\Villager;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;

class AdminStatisticsDashboardService
{

   public  function getTotalUsers()
   {
      return User::count();
   }

   public  function getTotalVillagers()
   {
      return Villager::count();
   }


   public  function subscriberdVillagers()
   {
      return Villager::where('subscription_status', 'subscribed')->count();
   }

   public  function unsubscriberdVillagers()
   {
      return Villager::where('subscription_status', 'not_subscribed')->count();
   }

   public function getTotalActiveMetrs()
   {
      return Meter::where('status', 'active')->count();
   }

   public function TotaBrokenMetrs()
   {
      return Meter::whereIn('status', ['broken', 'out_service'])->count();
   }

   public function getTotalBudget()
   {
      return Invoice::sum('total_amount');
   }

   public function getTotalPaid()
   {
      return Payment::sum('amount_paid');
   }

   public function getTotalUnpaidBudget()
   {
      return Invoice::orderBy('created_at', 'desc')->get()->unique('id')->sum('remaining_amount');
   }

   public function getRepairLosesAmount()
   {
      return FinancialLose::sum('amount_lose');
   }

   public function calculNetProfit()
   {
      $incom = Payment::sum('amount_paid');
      $loses = FinancialLose::sum('amount_lose');

      return  $incom - $loses;
   }

   public function getPaidPaymentsPercentage()
   {

    $paid = Payment::sum('amount_paid');
    $remaining = Invoice::sum('remaining_amount');

    $total = $paid + $remaining;

    return $total > 0 ? ($paid / $total) * 100 : 0;
   }

   public function getProfitMargin()
   {
      $incom = Payment::sum('amount_paid');
      $loses = FinancialLose::sum('amount_lose');

      $profit =  $incom - $loses;

      return $incom > 0 ? ($profit / $incom) * 100 : 0;
   }

   public function getLossPercentage(): float
   {
      $income = Payment::sum('amount_paid');
      $losses = FinancialLose::sum('amount_lose');

      return $income > 0 ? ($losses / $income) * 100 : 0;
   }


    public function getMonthlyPaymentsStats()
    {
        return DB::table('payments')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount_paid) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
