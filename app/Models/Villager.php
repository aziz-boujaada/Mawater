<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Villager extends Model
{
    protected $fillable = [
        'user_id',
        'subscription_status',
        'cin',
        'address'
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class , 'user_id');
    }
}
