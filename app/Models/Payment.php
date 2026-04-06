<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'collector_id',
        'amount_paid',
        'payment_date',
        'remaining_amount'

    ];

    public function invoice():BelongsTo{
        return $this->belongsTo(Invoice::class , 'invoice_id');
    }

    public function collector():BelongsTo{
        return $this->belongsTo(User::class , 'collector_id');
    }
}
