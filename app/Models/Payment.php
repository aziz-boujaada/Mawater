<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'collector_id',
        'amount_paid',
        'status',
        'payment_date',
        'remaining_amount'

    ];
}
