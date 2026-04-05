<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repair extends Model
{
    
protected $fillable = [
    'meter_id' ,
    'repair_agent_id',
    'problem_description',
    'repair_cost' ,
    'repair_date' ,
    'status'
];

  public function meter():BelongsTo{
    return $this->belongsTo(Meter::class , 'meter_id');
  }

  public function repair_agent():BelongsTo{
    return $this->belongsTo(User::class , 'repair_agent_id');
  }

  public function loses():HasMany{
    return $this->hasMany(FinancialLose::class , 'repair_id');
  }
}
