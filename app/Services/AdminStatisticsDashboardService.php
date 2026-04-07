<?php 
namespace App\Services;

use App\Models\Meter;
use App\Models\Payment;
use App\Models\User;
use App\Models\Villager;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;

class AdminStatisticsDashboardService {

   public  function getTotalUsers(){
      return User::count();
   }

    public  function getTotalVillagers(){
      return Villager::count();
   }


    public  function subscriberdVillagers(){
      return Villager::where('subscription_status' , 'subscribed')->count();
   }

     public  function unsubscriberdVillagers(){
      return Villager::where('subscription_status' , 'not_subscribed')->count();
   }

   public function getTotalActiveMetrs(){
    return Meter::where('status' , 'active')->count();
   }

   public function TotaBrokenMetrs(){
    return Meter::whereIn('status' , ['broken' , 'out_service'])->count();
   }

   public function getTotalBudget(){
      return Payment::sum('amount_paid');
   }

     public function getTotalUnpaidBudget(){
      return Payment::orderBy('created_at' , 'desc')->get()->unique('invoice_id')->sum('remaining_amount');

   }

}