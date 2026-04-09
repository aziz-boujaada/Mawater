<?php 

namespace App\Services;

use App\Models\Meter;

class UpdateMeterService{


   public function updateMeter($meter_data , $id){
      
       $meter = Meter::findOrFail($id);
       $meter->update($meter_data);
       
   }
}