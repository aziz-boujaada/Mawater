<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\MeterReadings;
use App\Models\Villager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoreInvoiceService
{


    public static function getBillingPeriod($reading_id) {
        $reading = MeterReadings::find($reading_id);
        if($reading){
            $billing_period = $reading->reading_date;
        }

        return $billing_period ; 
    }

    // check if  villager is subscribed in association or not 

    public static function isSubscribed($reading_id){
        $reading = MeterReadings::with('meter.villager')
        ->findOrFail($reading_id);
        
       
        $villager_status = $reading->meter->villager->subscription_status;
        return $villager_status ;
    }

    //calculate totla amount ;

    public static function calculateAmount($reading_id){
      $amount = 0 ; 
      $reading = MeterReadings::findOrFail($reading_id);
      $consumption = $reading->consumption ; 
      $villager_status = self::isSubscribed($reading_id);

      $villager_status === 'subscribed' 
       ? $amount =  $consumption * 3 
       : $amount = $consumption * 5 ; 
      
         return $amount ; 
    }

    public static function storeInvoice($invoice_request)
    {
     
        DB::transaction(function() use($invoice_request){
        $reading_id = $invoice_request['reading_id'];

        $billing_period = self::getBillingPeriod($reading_id);
        $total_amount = self::calculateAmount($reading_id);
       
    
            $invoice = Invoice::create([
                'reading_id' => $reading_id,
                'invoice_reference' => 'INV-' . now()->format('Y-m-d') . '-' . Str::random(6),
                'billing_period' => $billing_period , 
                'total_amount' => $total_amount , 
    
            ]);
    
            return $invoice;
        });
    }
}
