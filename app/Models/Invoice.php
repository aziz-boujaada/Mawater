<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_reference',
        'reading_id',
        'billing_period',
        'total_amount', 
    ];

   

    public function reading(){
        return $this->belongsTo(MeterReadings::class , 'reading_id');
    }
}
