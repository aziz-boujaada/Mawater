<?php

namespace App\Services;

use App\Models\Meter;
use App\Models\MeterReadings;
use Carbon\Carbon;
use Exception;

class StoreReadingService
{


   // give the last current reading to set as previous to register a new reading 
   public static function  getPreviousReading($meter_id)
   {

      $previous_reading = MeterReadings::where('meter_id', $meter_id)
         ->latest('reading_date')
         ->first();

      return  $previous_reading->current_reading ?? 0;
   }

   // calculate cinsumption and check if urrent reading greater than previous  befor calcul

   public static function calculateConsumpation($reading_data, $previous_reading)
   {
      $consumption = 0;

      if ($previous_reading > $reading_data['current_reading'] || $previous_reading == $reading_data['current_reading']) {
         throw new \Exception('cuerrnt reading must be grater than previous reading ');
      } else {
         $consumption = $reading_data['current_reading'] - $previous_reading;
      }
      return $consumption;
   }

   // check if raeding not suplicate at same month 
   public static function checkDuplicateReading($reading_data):void
   {

      $date = Carbon::parse($reading_data['reading_date']);
      $monthHasRecord = MeterReadings::where('meter_id', $reading_data['meter_id'])
         ->whereMonth('reading_date', $date->month)
         ->whereYear('reading_date', $date->year)
         ->exists();

      // if ($date->month < Carbon::now()->month) {
      //    throw new \Exception('You cant set a old date  ');
      // }
      
            if ($monthHasRecord) {
               throw new \Exception('You already add readings of this month');
            }
   }


   // add automatic reading when meter is broken based for avareg of consumption 

   public static function AutomtaicReading($meter_id){
      $meter = Meter::find($meter_id);
      $sumOfReadings = MeterReadings::where('meter_id' , $meter_id)->sum('current_reading');
      $countOfReadings = MeterReadings::where('meter_id' , $meter_id)->count();


      if(!$meter && $meter->status != "broken"){
         return null ; 
      }

      if($countOfReadings == 0) return null ; 
      return $sumOfReadings / $countOfReadings ; 
   }

   public static function storeReading($reading_data)
   {
      self::checkDuplicateReading($reading_data);
      $previous_reading  = self::getPreviousReading($reading_data['meter_id']);
      $consumption = self::calculateConsumpation($reading_data, $previous_reading);
      $averageComnsumption = self::AutomtaicReading($reading_data['meter_id']);
    
      if($averageComnsumption != null){
         $consumption = $averageComnsumption ;
         $current_reading = $previous_reading;
      }else{
         $current_reading = $reading_data['current_reading'] ;
      }

      $reading = MeterReadings::create([
         'meter_id' => $reading_data['meter_id'],
         'previous_reading' => $previous_reading,
         'current_reading' => $current_reading,
         'consumption' => $consumption,
         'reading_date' => $reading_data['reading_date']
      ]);

      return $reading;
   }
}
