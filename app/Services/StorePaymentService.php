<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class StorePaymentService
{


    public static function amountPaidByStatus($payment_data)
    {
        $amount_paid = 0;
        if ($payment_data['status'] == 'partial') {
            $amount_paid = $payment_data['amount_paid'];
        } elseif ($payment_data['status'] == 'paid') {
            $old_amount = Invoice::find($payment_data['ivoice_id']);
            $amount_paid = $old_amount->total_amount;
        }

        return $amount_paid;
    }

    // calculate remaining amount for partial payments 

    public static function calculeDRemainingAmount($payment_data)
    {

        $remaining_amount = 0;
        $amount_paid = $payment_data['amount_paid'];

        $invoice =  Invoice::find($payment_data['invoice_id']);
        $total_amount = $invoice->total_amount;

        if ($amount_paid > $total_amount) {
            throw new \Exception('the amount paid is grater than invoice total ');
        }

        if ($amount_paid < 0) {
            throw new \Exception('amount must be positiv price');
        }
        $remaining_amount = $total_amount - $amount_paid;

        return $remaining_amount;
    }
    public static function storePayment($payment_data)
    {

        $collector_id = Auth::id();
        $amount_paid = self::amountPaidByStatus($payment_data);
        $remaining_amount = self::calculeDRemainingAmount($payment_data);
        $payment = Payment::create([

            'invoice_id'  => $payment_data['invoice_id'],
            'collector_id' => $collector_id,
            'status' => $payment_data['status'],
            'amount_paid' => $amount_paid,
            'payment_date' => now(),
            
        ]);

        $payment->update(['remaining_amount' => $remaining_amount,]);

        return $payment;
    }
}
