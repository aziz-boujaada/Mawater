<?php

namespace App\Services;

use App\Models\FinancialLose;
use App\Models\Repair;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreRepairService
{


    public function storeRepair($repair_info)
    {

        return DB::transaction(function () use ($repair_info) {

            $repair =  Repair::create([
                'meter_id' => $repair_info['meter_id'],
                'repair_agent_id' => Auth::id(),
                'problem_description' => $repair_info['problem_description'],
                'repair_cost' => $repair_info['repair_cost'],
                'status' => $repair_info['status'],
                'repair_date' => now()


            ]);

            FinancialLose::create([
                'meter_id' => $repair->meter_id,
                'repair_id' => $repair->id,
                'amount_lose' => $repair->repair_cost,
            ]);
            return $repair;
        });
    }

}
