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
        'collector_id'
    ];

   

    public function reading(){
        return $this->belongsTo(MeterReadings::class , 'reading_id');
    }

    public function collector() :BelongsTo{
        return $this->belongsTo(User::class , 'collector_id');
    }
}
