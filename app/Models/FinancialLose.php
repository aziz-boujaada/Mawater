<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialLose extends Model
{

    protected $fillable = [
        'meter_id',
        'repair_id',
        'amount_lose',
        'description'
    ];

    public function repair():BelongsTo{
        return $this->belongsTo(Repair::class , 'repair_id');
    }
    
}
