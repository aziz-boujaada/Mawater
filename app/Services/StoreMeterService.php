<?php
namespace App\Services;
use App\Models\Meter;
use Illuminate\Support\Str;

class StoreMeterService {

   public static function storeMeter($meterData):Meter{
     
      $meter = Meter::create([
        'meter_reference' =>'#REF-' . Str::uuid() ,
        'villager_id' => $meterData['villager_id'],
        'status' => $meterData['status'],
        'installation_date' => $meterData['installation_date']
      ]);
    
      return $meter;
   }
}