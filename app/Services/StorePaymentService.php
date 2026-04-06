<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class StorePaymentService
{




    public static function calculeDRemainingAmount($payment_data)
    {
        $invoice = Invoice::findOrFail($payment_data['invoice_id']);

        $total_amount = $invoice->total_amount;
        $already_paid = Payment::where('invoice_id', $invoice->id)->sum('amount_paid');
        $amount_paid = $payment_data['amount_paid'];

        $remaining_before_payment = $total_amount - $already_paid;

        if ($amount_paid > $remaining_before_payment) {
            throw new \Exception('The amount paid is greater than remaining amount');
        }

        return $remaining_before_payment - $amount_paid;
    }


    public static function storePayment($payment_data)
    {

        $collector_id = Auth::id();
        $remaining_amount = self::calculeDRemainingAmount($payment_data);
        $payment = Payment::create([

            'invoice_id'  => $payment_data['invoice_id'],
            'collector_id' => $collector_id,
            'amount_paid' => $payment_data['amount_paid'],
            'payment_date' => now(),

        ]);

        $payment->update(['remaining_amount' => $remaining_amount,]);
        return $payment;
    }
}
