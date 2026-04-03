<?php
namespace App\Services;

use App\Models\Repair;
use Illuminate\Support\Facades\Auth;

class StoreRepairService{


   public static function storeRepair($repair_info){
      
        return Repair::create([
            'meter_id' => $repair_info['meter_id'],
            'repair_agent_id' => Auth::id(),
            'problem_description' => $repair_info['problem_description'],
            'repair_cost' => $repair_info['repair_cost'],
            'status' => $repair_info['status'],
            'repair_date' => now()
        ]);
         
   }
}