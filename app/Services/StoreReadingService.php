<?php

namespace App\Services;

use App\Models\Meter;
use App\Models\MeterReadings;
use App\Repositories\ReadingRepository;
use Carbon\Carbon;
use Exception;

class StoreReadingService
{

   public function __construct(protected ReadingRepository $readingRepository) {}
   // give the last current reading to set as previous to register a new reading 
   public function  getPreviousReading($meter_id)
   {

      $reading = MeterReadings::where('meter_id', $meter_id)
         ->latest('id')
         ->first();

      return  $reading->current_reading ?? 0;
   }

   // calculate cinsumption and check if urrent reading greater than previous  befor calcul

   public function calculateConsumpation($reading_data, $previous_reading)
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
   public function checkDuplicateReading($reading_data): void
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

   public function checkPreviuosDate($reading_data){
       
       $last_reading = MeterReadings::where('meter_id' , $reading_data['meter_id'])
       ->latest('reading_date')
       ->first();
       
       if(!$last_reading){
         return;
       }

       $new_date = Carbon::parse($reading_data['reading_date']);
       $last_date = Carbon::parse($last_reading->reading_date);
       if($new_date->lessThanOrEqualTo($last_date)){
         throw new Exception('you cannot add reading to old date , please inter a vlaid date ');
       }
      
   }


   // add automatic reading when meter is broken based for avareg of consumption 

   public function AutomtaicReading($meter_id, $meter)
   {

      $sumOfConsumption = MeterReadings::where('meter_id', $meter_id)->sum('consumption');
      $countOfReadings = MeterReadings::where('meter_id', $meter_id)->count();


      if (!$meter || $meter->status != "broken") {
         return null;
      }

      if ($countOfReadings == 0) return null;
      return $sumOfConsumption / $countOfReadings;
   }

   public function storeReading($reading_data)
   {
      $this->checkDuplicateReading($reading_data);
      $this->checkPreviuosDate($reading_data);
      $previous_reading  = $this->getPreviousReading($reading_data['meter_id']);
      
      $meter = Meter::find($reading_data['meter_id']);
      if (!$meter) {
         throw new Exception('meter not found');
      }
      if ($meter->status != 'broken') {
         $consumption = $this->calculateConsumpation($reading_data, $previous_reading);
         $current_reading = $reading_data['current_reading'];
      } else {

         $averageComnsumption = $this->AutomtaicReading($reading_data['meter_id'], $meter);

         if ($averageComnsumption === null) {
            throw new Exception('cannot calculate automatic reading no history');
         }

         $consumption = $averageComnsumption;
         $current_reading = $previous_reading + $consumption;
      }

      return $this->readingRepository->storeReading(
         $reading_data,
         $previous_reading,
         $current_reading,
         $consumption
      );
   }
}
