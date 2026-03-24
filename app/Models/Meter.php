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
        return $this->belongsTo(User::class , 'villager_id');
    }
}
