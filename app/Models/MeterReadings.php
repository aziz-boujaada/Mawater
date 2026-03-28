<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MeterReadings extends Model
{
    protected $fillable = [

        'meter_id',
        'previous_reading',
        'current_reading',
        'consumption',
        'reading_date'
    ];


    public function meter():BelongsTo {
        return $this->belongsTo(Meter::class , 'meter_id');
    }

    public function invoice():HasOne {
        return $this->hasOne(Invoice::class , 'reading_id');
    }
}
