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

   

    public function readings(){
        return $this->hasMany(MeterReadings::class , 'reading_id');
    }
}
