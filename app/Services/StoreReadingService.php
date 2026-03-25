<?php
namespace App\Services;

use App\Models\MeterReadings;
use Exception;

class StoreReadingService {

   public static function storeReading($reading_data){
     

     $consumption = 0 ; 

     if($reading_data['previous_reading'] > $reading_data['current_reading']){
        throw new \Exception('cuerrnt reading must be grater than previous reading ');
     }else{
         $consumption = $reading_data['current_reading'] - $reading_data['previous_reading'];
     }
     
    $monthHasRecord = MeterReadings::where('meter_id' , $reading_data['meter_id'])
    ->whereDate('reading_date' , $reading_data['reading_date'])
    ->exists();

    if($monthHasRecord){
          throw new \Exception('You already add readings of this month');
    }

    $lastReading = MeterReadings::where('meter_id' , $reading_data['meter_id'])
    ->latest('reading_date')
    ->first() ;

    if($lastReading && $reading_data['previous_reading'] < $reading_data['current_reading']){
                  throw new \Exception('previous reading must be mutch to current');

    }
     
     $reading = MeterReadings::create([
         'meter_id' => $reading_data['meter_id'],
         'previous_reading' => $reading_data['previous_reading'],
         'current_reading' => $reading_data['current_reading'],
         'consumption' => $consumption,
         'reading_date' => $reading_data['reading_date']
         ]);
         
         return $reading;
   }
}