<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meter extends Model
{
    protected $fillable = [
        'meter_reference',
        'villager_id',
        'status' ,
        'installation_date'
    ];

    public function villager(){
        return $this->belongsTo(Villager::class , 'villager_id');
    }

    public function metterReadings(){
        return $this->hasMany(MeterReadings::class , 'meter_id');
    }
}
