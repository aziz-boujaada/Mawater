<?php
namespace  App\Repositories;

use App\Models\MeterReadings;

class ReadingRepository{

  public function storeReading($reading_data , $previous_reading , $current_reading , $consumption){
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